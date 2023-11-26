<?php

namespace Dcat\Admin\Contracts;

interface ColoredTag
{
    public function getTag() : string;
    public function getColor() : string;
}
