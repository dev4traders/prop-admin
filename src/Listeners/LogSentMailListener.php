<?php

namespace Dcat\Admin\Listeners;

use Dcat\Admin\Models\DomainEmail;
use Illuminate\Mail\Events\MessageSent;

class LogSentMailListener
{
    public function __construct()
    {
        //
    }

    public function handle(MessageSent $event)
    {
        DomainEmail::saveFromSymfonySentMessage($event->sent->getSymfonySentMessage());
    }
}

