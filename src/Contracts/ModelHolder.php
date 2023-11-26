<?php

namespace Dcat\Admin\Contracts;

interface ModelHolder
{
    /**
     * @param  Fluent|\Illuminate\Database\Eloquent\Model|null  $model
     * @return Fluent|$this|\Illuminate\Database\Eloquent\Model
     */
    public function model($model = null);
}
