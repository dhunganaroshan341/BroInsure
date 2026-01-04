<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table='vdcmcpts';

    public function province(){
        return $this->belongsTo(Province::class,'state_id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
}
