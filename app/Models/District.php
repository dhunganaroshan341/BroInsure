<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    public function  province():BelongsTo
    {
        return $this->belongsTo(Province::class,'state_id');
    }
    public function  cities():HasMany
    {
        return $this->hasMany(City::class,'district_id');
    }
}
