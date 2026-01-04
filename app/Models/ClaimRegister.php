<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class ClaimRegister extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;
    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded = [];

    public function scrunities()
    {
        return $this->hasMany(Scrunity::class, 'claim_no_id')->take(1);
    }
    public function Allscrunities()
    {
        return $this->hasOne(Scrunity::class, 'claim_no_id');
    }

    public function firstClaims(){
        return $this->hasOne(InsuranceClaim::class,'register_no');
    }
    public function claim_note(){
        return $this->hasOne(ClaimNote::class,'claim_no_id');
    }
    public function claims(){
        return $this->hasMany(InsuranceClaim::class,'register_no');
    }
}
