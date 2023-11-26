<?php

namespace Dcat\Admin\Models;

use Dcat\Admin\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;

class NotificationSubscription extends Model
{
    use HasDomain;

    protected $fillable = ['type', 'user_id', 'domain_id', 'created_at', 'updated_at'];

    const TABLE_NAME = 'admin_notification_subscriptions';

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

        $this->setTable(config('admin.database.notification_subscriptions_table') ?: self::TABLE_NAME);
    }

    public function user()
    {
        $userModel = config('admin.database.users_model');
        return $this->belongsTo($userModel);
    }

    public function scopeForType($query, $type)
    {
        $query->where('type', $type);
    }

}
