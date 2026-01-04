<?php
namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait CreatedByTrait
{
    protected static function bootCreatedByTrait()
    {
        static::creating(function ($modal) {

            $modal->created_by = getUserDetail()->id;
        });
        static::updating(function ($modal) {

            $modal->updated_by = getUserDetail()->id;
        });
        if (Schema::hasColumn((new static)->getTable(), 'archived_at')) {
            # code...
            static::deleted(function ($modal) {
                $modal->archived_by = getUserDetail()->id;
                static::withoutEvents(function () use ($modal) {
                    $modal->save();
                });
            });
        }

    }
}
