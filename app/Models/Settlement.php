<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Settlement extends Model implements Auditable
{
    use HasFactory,SoftDeletes,CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    
    protected $guarded=[];

    public function member(){
        return $this->belongsTo(Member::class,'member_id');
    }
    public function group_heading(){
        return $this->belongsTo(GroupPackageHeadings::class,'group_package_heading_id');
    }
}
