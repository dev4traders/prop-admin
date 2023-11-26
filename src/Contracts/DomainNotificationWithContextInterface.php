<?php

namespace Dcat\Admin\Contracts;

interface DomainNotificationWithContextInterface
{
    public function getDomainId() : int;
    public function getContextObject() : ?EmailContextObjectInterface;
}
