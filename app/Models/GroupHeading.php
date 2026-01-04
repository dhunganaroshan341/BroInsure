<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GroupHeading extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    
    protected $guarded=[];
    protected $table='group_headings';
    
    public function group_package(){
        return $this->belongsTo(Group::class,'group_id');
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }
    public function heading(){
        return $this->belongsTo(InsuranceHeading::class,'heading_id');
    }
}
