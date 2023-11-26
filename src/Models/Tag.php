<?php

namespace Dcat\Admin\Models;

use Dcat\Admin\Traits\HasDomain;
use Dcat\Admin\Contracts\ColoredTag;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Tag extends Model implements ColoredTag
{
    use HasDateTimeFormatter;
    use HasDomain;

    const TABLE_NAME = 'admin_tags';
    const TABLE_NAME_TAGGABLES = 'admin_taggables';
    const FIELD_NAME_TAGGABLE = 'taggable';

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

        $this->setTable(config('admin.database.tags_table') ?: self::TABLE_NAME);
    }

    public function getTag(): string
    {
        return $this->title;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
