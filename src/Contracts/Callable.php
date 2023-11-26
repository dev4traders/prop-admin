<?php

namespace Dcat\Admin\Contracts;

interface Callable
{
    public function __call($method, $parameters);
}
