<?php

namespace Dcat\Admin\Models;

use Illuminate\Support\Str;
use Dcat\Admin\Traits\HasDomain;
use Illuminate\Support\Collection;
//use Illuminate\Auth\Authenticatable;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\Access\Authorizable;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Contracts\NotifiableInterface;
use Dcat\Admin\Traits\HasDashboardNotifications;
use Dcat\Admin\Traits\HasNotificationSubscriptions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Administrator extends Authenticatable implements NotifiableInterface
{
    //    Authenticatable,
    use HasPermissions;
    use HasDateTimeFormatter;
    use Notifiable;
    use HasDomain;
    use HasNotificationSubscriptions;
    use HasDashboardNotifications;

    const DEFAULT_ID = 1;

    protected $fillable = ['username', 'password', 'name', 'avatar_url'];
    protected $appends = ['avatar'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
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

        $this->setTable(config('admin.database.users_table'));
    }

    /**
     * Get avatar attribute.
     *
     * @return mixed|string
     */
    public function getAvatarAttribute(): string
    {
        return $this->getAvatar();
    }

    public function getAvatar(): string
    {
        $avatar = $this->avatar_url;

        if ($avatar) {
            if (!URL::isValidUrl($avatar)) {
                $avatar = Storage::disk(config('admin.upload.disk'))->url($avatar); //todo:: check and fix
            }

            return $avatar;
        }

        return admin_asset(config('admin.default_avatar') ?: '@admin/images/default-avatar.jpg');
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id')->withTimestamps();
    }

    public function managed_domains(): HasMany
    { //todo:: renamed to managed_domains
        $relatedModel = config('admin.database.domains_model');
        return $this->hasMany($relatedModel, 'manager_id');
    }

    public function domain(): BelongsTo
    {
        $relatedModel = config('admin.database.domains_model');
        return $this->belongsTo($relatedModel, 'domain_id');
    }

    public function canSeeMenu($menu): bool
    {
        return true;
    }

    public function routeNotificationForDomainMailer($notifiable): string
    {
        return $this->email;
    }

}
