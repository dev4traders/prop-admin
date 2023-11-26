<?php

namespace Dcat\Admin\Models;

use Dcat\Admin\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Dcat\Admin\Contracts\MailDepartmentInterface;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class EmailDepartment extends Model implements MailDepartmentInterface
{
    use HasDateTimeFormatter;
    use HasDomain;

    const TABLE_NAME = 'admin_mail_departments';

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

        $this->setTable(config('admin.database.email_departments_table') ?: self::TABLE_NAME);
    }

    public function getEmailAddressAttribute() : string {
        return $this->getAddress();
    }

    public function scopeIsSystem(Builder $query) : Builder {
        return $query->where('is_system', 1);
    }

    public function getAddress() : string {
        if(!empty($this->custom_domain))
            return $this->name.'@'. $this->custom_domain;

        return $this->name.'@'. $this->domain->host;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDomainId(): int {
        return $this->domain->id;
    }

    public function getFromName(): string {
        return $this->from_name;
    }

    public function getMainTemplate(): string {
        return $this->main_template;
    }
}
