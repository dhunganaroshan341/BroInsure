<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceHeading extends Model implements Auditable
{
    use HasFactory,SoftDeletes,CreatedByTrait;
    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded=[''];
    public function setNameAttribute($value)
    {
        $this->attributes['name']=$value?strtoupper($value):null;
    }
    public function sub_headings():HasMany
    {
        return $this->hasMany(InsuranceSubHeading::class,'heading_id');
    }
    public function packages():BelongsToMany
    {
        return $this->belongsToMany(Package::class,'package_headings','heading_id','package_id');
    }
    public function group_heading() : HasMany {
        return $this->hasMany(GroupHeading::class,'heading_id');
    }
}
