<?php

namespace Dcat\Admin\Models;

use Dcat\Admin\Enums\IconType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuDomainSetting extends Model
{
    protected $casts = ['icon_type' => IconType::class];

    protected $appends = [ 'icon' ];
    protected $fillable = [ 'visible' ];

    const TABLE_NAME = 'admin_menu_domain_settings';

    /**
     * {@inheritDoc}
    */
    public function __construct(array $attributes = [])
    {
        $this->init();

        parent::__construct($attributes);
    }

    protected function init()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.menu_domain_settings_table') ?: self::TABLE_NAME);
    }

    protected function menu() : BelongsTo {
        $menuModel = config('admin.database.menu_model');
        return $this->belongsTo($menuModel);
    }

    protected function domain() : BelongsTo {
        $domainModel = config('admin.database.domains_model');
        return $this->belongsTo($domainModel);
    }

    public function getIconAttribute() {
        if(is_null($this->icon_type))
            return null;

        return $this->icon_type == IconType::SVG ? 'icon-svg '.$this->icon_svg : $this->icon_font;
    }
}
