<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';

    protected $guarded = [];

    public function headings(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceHeading::class, 'package_headings', 'package_id', 'heading_id');
    }
    public function packageheadings(): HasMany
    {
        return $this->HasMany(PackageHeading::class, 'package_id', 'id');
    }

    public function group(){
        return $this->belongsToMany(Group::class,'group_packages','package_id','group_id');
    }
}
