<?php

namespace Dcat\Admin;

interface DcatEnumColored extends DcatEnum
{
    public function color(): string;
}