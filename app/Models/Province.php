<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory;
    protected $table = 'states';
    protected static function booted()
    {
        static::addGlobalScope('in_nepal', function (Builder $builder) {
            $nepalID = DB::table('countries')
                ->where('name', 'Nepal')
                ->OrWhere('code', 'NP')
                ->value('id');
            $builder->where('country_id', $nepalID);
        });
    }
}
