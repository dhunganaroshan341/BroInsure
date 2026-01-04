<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;

class InsuranceClaimLog extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CreatedByTrait;
    use \OwenIt\Auditing\Auditable;
    const DELETED_AT = 'archived_at';
    protected $guarded = [];
}
