<?php

namespace Dcat\Admin\Traits;

use Dcat\Admin\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function tags() : MorphToMany
    {
        return $this->morphToMany(Tag::class, Tag::FIELD_NAME_TAGGABLE, Tag::TABLE_NAME_TAGGABLES);
    }
}
