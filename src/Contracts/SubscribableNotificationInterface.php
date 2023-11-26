<?php


namespace Dcat\Admin\Contracts;

use Illuminate\Support\Collection;

interface SubscribableNotificationInterface
{
    public function subscribers() : Collection;

    public function getTitle() : string;

    public function getDomainId() : int;
}
