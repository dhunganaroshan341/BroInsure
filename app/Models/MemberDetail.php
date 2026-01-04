<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function citizenshipDistrict(){
        return $this->belongsTo(District::class,'citizenship_district');
    }
}
