<?php

namespace Dcat\Admin\Contracts;

interface EmailContextObjectInterface
{
    public function getContextId() : string;
}