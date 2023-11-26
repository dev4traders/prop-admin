<?php

namespace Dcat\Admin\Models;

use Dcat\Admin\Enums\HttpSchemaType;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    use HasDateTimeFormatter;

    protected $casts = [
        'schema' => HttpSchemaType::class
    ];

    protected $fillable = ['host','manager_id'];

    public function __construct(array $attributes = [])
    {
        $this->init();

        parent::__construct($attributes);
    }

    protected function init()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.domains_table'));
    }

    public function default_roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.domain_role_defaults_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'domain_id', 'role_id')->withTimestamps();
    }

    public function manager() : BelongsTo
    {
        $managerModel = config('admin.database.users_model');
        return $this->belongsTo($managerModel, 'manager_id');
    }

    public static function fromRequest() : Domain {
        if(request())
            $host = request()->getHost();
        else
           $host = Str::of(config('app.url'))->remove('http://')->remove('https://');

        $domain = self::whereHost($host)->first();

        if(!$domain)
            throw new \Exception('Domain not setup. Requiested host: '.$host );

        return $domain;
    }

    public function getFullUrlAttribute()
    {
        return $this->schema->value.'://'.$this->host;
    }

}
