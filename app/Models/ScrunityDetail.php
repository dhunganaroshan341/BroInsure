<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ScrunityDetail extends Model implements Auditable
{
    use HasFactory,CreatedByTrait;

    use \OwenIt\Auditing\Auditable;

    protected $guarded=[];

    public function scrunity():BelongsTo
    {
        return $this->belongsTo(Scrunity::class,'scrunity_id');
    }
    public function group_package():BelongsTo
    {
        return $this->belongsTo(GroupPackageHeadings::class,'group_package_heading_id');
    }

    public function insuranceHeading()
    {
        return $this->belongsTo(InsuranceHeading::class, "heading_id");
    }
}
