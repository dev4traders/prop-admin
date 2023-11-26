<?php

namespace Dcat\Admin\Traits;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasCountedEnum
{

    public static function enumCounts(string $fieldName, string $enumClass, ?\Closure $queryCallback = null) : Collection {
        $query = self::select($fieldName, DB::raw('COUNT(*) as count'))
            ->whereIn($fieldName, $enumClass::values())
            ->groupBy($fieldName)
            ->orderBy($fieldName);

        if($queryCallback !== null)
            call_user_func($queryCallback, $query);

        $items = $query->pluck('count', $fieldName);

        $data = new Collection();
        foreach($items as $enum => $count) {
            $label = $enumClass::from($enum)->label();
            $data[$enum] = $label.' ('.$count.')';
        }

        return $data;
    }

}
