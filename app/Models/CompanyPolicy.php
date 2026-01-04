<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyPolicy extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';

    protected $guarded = [];
    protected static function booted()
    {
        static::updating(function ($companyPolicy) {
            // Check if the imitation_days field is being updated
            if ($companyPolicy->isDirty('imitation_days')) {
                $newImitationDays = $companyPolicy->imitation_days;
                // Update related GroupHeading records
                $groupHeadings = GroupHeading::whereHas('group', function ($query) use ($companyPolicy) {
                    $query->where('policy_id', $companyPolicy->id)
                        ->where('is_imitation_days_different', 'N')
                    ;
                })
                    ->get();
                foreach ($groupHeadings as $groupHeading) {
                    $groupHeading->update(['imitation_days' => $newImitationDays]);
                }
            }
        });
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withoutGlobalScopes();
    }
    public function groups()
    {
        return $this->hasMany(Group::class, 'policy_id');
    }
    public function memberPolicies()
    {
        return $this->hasMany(MemberPolicy::class, 'policy_id');
    }
}
