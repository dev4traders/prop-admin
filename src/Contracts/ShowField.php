<?php

namespace Dcat\Admin\Contracts;

interface ShowField
{
    /**
     * Add a model field to show.
     *
     * @param  string  $name
     * @param  string  $label
     * @return Field
     */
    public function field($name, $label = '');
}
