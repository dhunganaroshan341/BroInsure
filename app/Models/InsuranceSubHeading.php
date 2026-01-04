<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class InsuranceSubHeading extends Model implements Auditable
{
    use HasFactory,SoftDeletes,CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded=[];
    public function setNameAttribute($value)
    {
        Log::error($value);
        $this->attributes['name']=$value?ucwords(strtolower($value)):null;
    }
    public function heading():BelongsTo
    {
        return $this->belongsTo(InsuranceHeading::class,'heading_id');
    }
}
