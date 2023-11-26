<?php

namespace Dcat\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ControllerHelpTopic extends Model
{
    protected $table = 'admin_controller_help_topics';

    public $timestamps = false;

    public function getUrlAttribute() : string{
        $docs = config('admin.documentation_url');
        return $docs.$this->topic_url;
    }

    public static function docsEnabled() : bool {
        return !empty(config('admin.documentation_url'));
    }

}
