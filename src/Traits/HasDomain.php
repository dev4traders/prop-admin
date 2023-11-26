<?php

namespace Dcat\Admin\Traits;

use Dcat\Admin\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDomain
{
    public function scopeForDomain(Builder $query, int $domainId) : Builder
    {
        return $query->where('domain_id', $domainId);
    }

    public function scopeOwnDomainOnly(Builder $query): Builder {
        return $query->where('domain_id', Admin::domain()->id);
    }

    public function domain() : BelongsTo
    {
        $domainsModel = config('admin.database.domains_model');
        return $this->belongsTo($domainsModel, 'domain_id');
    }

}
