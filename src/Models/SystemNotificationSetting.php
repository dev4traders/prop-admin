<?php
namespace Dcat\Admin\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Dcat\Admin\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemNotificationSetting extends Model {

    use HasDomain;
    //use Cachable; // todo::move to child project

    const TABLE_NAME = 'admin_system_notification_settings';

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

        $this->setTable(config('admin.database.system_notification_settings_table') ?: self::TABLE_NAME);
    }

    public function domain() : BelongsTo
    {
        $domainModel = config('admin.database.domains_model');
        return $this->belongsTo($domainModel, 'domain_id');
    }

    public static function fillTypesForDomains() : void {
        $types = config('admin.system_notification_types');
        $domainModel = config('admin.database.domains_model');

        /** @var mixed $domains */
        $domains = $domainModel::all();

        collect($types)->each(function ($type) use($domains) {
            $domains->each( function($domain) use($type) {

                self::insertOrIgnore([
                    'domain_id' => $domain->id,
                    'type' => self::getTypeFromClass($type),
                    'send_email' => 1,
                    'send_notification' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } );
        });
    }

    public static function getTypeFromClass(string $className) : string {
        return Str::remove('App\\Notifications\\', $className);
    }

    public static function getTitle(string $className) : string {
        return __('admin.notification.'.self::getTypeFromClass($className));
    }
}
