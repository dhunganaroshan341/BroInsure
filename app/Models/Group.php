<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;
    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ? ucwords(strtolower($value)) : null;
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function headings()
    {
        return $this->hasMany(GroupHeading::class, 'group_id');
    }
    public function memberPolicies()
    {
        return $this->hasMany(MemberPolicy::class, 'group_id');
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(CompanyPolicy::class,'policy_id');
    }
}
