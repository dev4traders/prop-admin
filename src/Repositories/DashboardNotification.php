<?php

namespace Dcat\Admin\Repositories;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Illuminate\Notifications\DatabaseNotification;

class DashboardNotification extends Data {

    function __construct(
        public string $icon,
        public string $title,
        public string $message,
        public string $time,
        public bool $isRead = false
    ) {

    }

    public static function fromDatabaseNotification(DatabaseNotification $notification) {
        $type = $notification->type;

        $icon = $type::getIcon(); //todo::think about using interfaces
        $title = Str::remove('App\\Notifications\\', $type);
        $message = $notification->data->message;
        $time = $notification->created_at->diffForHumans();

        return new static($icon, $title, $message, $time);
    }

    // public function toArray() {
    //     return [
    //         'icon' => $this->icon,
    //         'title' => $this->title,
    //         'time' => $this->time,
    //         'message' => $this->message,
    //         'is_read' => $this->isRead,
    //     ];
    // }
}
