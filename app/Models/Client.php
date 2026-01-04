<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model  implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded = [];

    public function setNameAttribute( $value)
    {
        $this->attributes['name']=$value?ucwords(strtolower($value)):null;
    }
    
    protected static function booted()
    {
        static::addGlobalScope('withoutdefault', function (Builder $builder) {
            $builder->where('id', '!=', 1);
        });
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function policies(): HasMany
    {
        return $this->hasMany(CompanyPolicy::class, 'client_id');
    }
    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'client_id');
    }
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'client_id');
    }
    public function insurance_claims(): HasManyThrough
    {
        return $this->hasManyThrough(
            InsuranceClaim::class,
            Member::class,
            'client_id',
            'member_id',
            'id',
            'id'
        );
    }
}
