<?php
namespace Dcat\Admin\Models;

use Dcat\Admin\Traits\HasDomain;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DomainMailSetting extends Model {

    use HasDateTimeFormatter;
    use HasDomain;

    protected $primaryKey = "domain_id";
    public $incrementing = false;
    protected $fillable = ['transport', 'encryption',  'default_department_id', 'host', 'port', 'username', 'password'];

    const TABLE_NAME = 'admin_mail_settings';

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

        $this->setTable(config('admin.database.mail_settings') ?: self::TABLE_NAME);
    }


    public function default_department() : HasOne {
        $departmentModel = config('admin.database.departments_model');
        return $this->hasOne($departmentModel, 'id', 'default_department_id');
    }
}
