<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MemberPolicy extends Pivot
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    // use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $table = 'member_policies';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function companyPolicy()
    {
        return $this->belongsTo(CompanyPolicy::class, 'policy_id');
    }
    // public function package() {
    //     return $this->belongsTo(Package::class,'package_id');
    // }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
