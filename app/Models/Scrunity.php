<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Scrunity extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';

    const STATUS_DRAFT = 'Draft';
    const STATUS_REQUEST = 'Request';
    const STATUS_VERIFIED = 'Verified';
    const STATUS_APPROVED = 'Approved';
    const STATUS_CLAIMED = 'Claimed';
    const STATUS_REJECTED= 'Rejected';

    const STATUS_ALL = [self::STATUS_VERIFIED, self::STATUS_CLAIMED, self::STATUS_DRAFT, self::STATUS_APPROVED, self::STATUS_REQUEST, self::STATUS_APPROVED,self::STATUS_REJECTED];
    protected $guarded = [];

    public function details(): HasMany
    {
        return $this->hasMany(ScrunityDetail::class, 'scrunity_id');
    }
    public function memberPolicy(): BelongsTo
    {
        return $this->belongsTo(MemberPolicy::class, 'member_policy_id');
    }
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function relative()
    {
        return $this->belongsTo(MemberRelative::class);
    }
    public function claims(){
        return $this->hasMany(InsuranceClaim::class,'scrutiny_id');
    }
}
