<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceClaim extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';

    const STATUS_RECEIVED = 'Received';
    const STATUS_REGISTERED = 'Registered';
    const STATUS_SCRUNITY = 'Scrunity';
    const STATUS_REQUEST = 'Request';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_RESUBMISSION = 'Resubmission';
    const STATUS_HOLD = 'Hold';
    const STATUS_RELEASE = 'Release';
    const STATUS_DOCUMENT_CORRECTION = 'Document_Correction';
    const STATUS_VERIFIED = 'Verified';
    const STATUS_APPROVED = 'Approved';

    const STATUS_ALL = [self::STATUS_RECEIVED, self::STATUS_REGISTERED, self::STATUS_SCRUNITY, self::STATUS_REQUEST, self::STATUS_REJECTED, self::STATUS_RESUBMISSION, self::STATUS_HOLD, self::STATUS_RELEASE, self::STATUS_DOCUMENT_CORRECTION, self::STATUS_APPROVED, self::STATUS_VERIFIED];

    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function heading()
    {
        return $this->belongsTo(InsuranceHeading::class, 'heading_id');
    }
    public function sub_heading()
    {
        return $this->belongsTo(InsuranceSubHeading::class, 'sub_heading_id');
    }
    public function relation()
    {
        return $this->belongsTo(MemberRelative::class, 'relative_id');
    }
    // public function lot()
    // {
    //     return $this->belongsTo(InsuranceLot::class, 'lot_no');
    // }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function relative(): BelongsTo
    {
        return $this->belongsTo(MemberRelative::class, 'relative_id');
    }

    public function claimRegister()
    {
        return $this->belongsTo(ClaimRegister::class, "register_no");
    }
    public function auditsData(): HasMany
    {
        return $this->hasMany(Audit::class, 'auditable_id')
            ->where('auditable_type', self::class);
    }
    public function scrunity()
    {
        return $this->belongsTo(Scrunity::class, "scrutiny_id");
    }
    public function logs(): HasMany
    {
        return $this->hasMany(InsuranceClaimLog::class, 'insurance_claim_id');
    }
    public function claimNote()
    {
        return $this->belongsTo(ClaimNote::class, 'register_no', 'claim_no_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, "group_id");
    }
}
