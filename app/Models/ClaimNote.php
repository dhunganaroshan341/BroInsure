<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property int $id
 * @property int $claim_no_id
 * @property int $client_id
 * @property \Carbon\Carbon $from_date
 * @property \Carbon\Carbon $to_date
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $organization_id
 * @property int $sub_organization_id
 * @property int $archived_by
 * @property \Carbon\Carbon $archived_at
 *
 * @property ClaimRegister $claimRegister
 * @property Client $client
 * @property Member $member
 * @property MemberRelative $relative
 */
class ClaimNote extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded = [];
    const STATUS_APPROVED = 'Approved';
    const STATUS_ALL = [self::STATUS_APPROVED];


    public function claimRegister()
    {
        return $this->belongsTo(ClaimRegister::class, 'claim_no_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withoutglobalscopes();
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function relative()
    {
        return $this->belongsTo(MemberRelative::class);
    }
    public function insuranceCliams()
    {
        return $this->hasMany(InsuranceClaim::class, 'register_no', 'claim_no_id');
    }

}
