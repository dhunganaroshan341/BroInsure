<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';

    protected $guarded = [];

    public function setNameAttribute($value)
    {
        // Log::error($value);
        $this->attributes['name']=$value?ucwords(strtolower($value)):null;
    }

    public function relatives(): HasMany
    {
        return $this->hasMany(MemberRelative::class, 'member_id');
    }
    public function attachments(): HasMany
    {
        return $this->hasMany(MemberAttachment::class, 'member_id');
    }
    public function details(): HasOne
    {
        return $this->hasOne(MemberDetail::class, 'member_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function group_package()
    // {
    //     return $this->belongsToMany(GroupPackage::class, 'member_policies', 'member_id', 'group_pacakge_id')->using(MemberPolicy::class)->withPivot('policy_no', 'start_date', 'end_date');
    // }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id')->withoutglobalscopes();
    }

    public function insuranceClaim(): HasMany
    {
        return $this->hasMany(InsuranceClaim::class, 'member_id');
    }
    public function memberPolicy(): HasOne
    {
        return $this->hasOne(MemberPolicy::class, 'member_id');
    }
    public function allMemberPolicy(): hasMany
    {
        return $this->hasMany(MemberPolicy::class, 'member_id');
    }

    public function currentMemberPolicy(): HasOne
    {
        return $this->hasOne(MemberPolicy::class, 'member_id')->where('is_current', 'Y');
    }

    public function companyPolicies(): HasMany
    {
        return $this->hasMany(CompanyPolicy::class, 'client_id', 'client_id')
            ->orderBy('created_at', 'desc')
            ->take(1);
    }
    public function allCompanyPolicies(): HasMany
    {
        return $this->hasMany(CompanyPolicy::class, 'client_id', 'client_id')
            ->orderBy('created_at', 'desc');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    public function presentCity()
    {
        return $this->belongsTo(City::class, 'present_city');
    }
    public function permProvince()
    {
        return $this->belongsTo(Province::class, 'perm_province');
    }

    public function permDistrict()
    {
        return $this->belongsTo(District::class, 'perm_district');
    }

    public function permCity()
    {
        return $this->belongsTo(City::class, 'perm_city');
    }
}
