<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\CreatedByTrait;

class Module extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory,SoftDeletes, CreatedByTrait;
    const DELETED_AT = 'archived_at';
    
    protected $fillable = [
        'modulename',
        'parentmoduleid',
        'url',
        'icon',
        'orderby',
        'created_by',  'updated_by',  'organization_id',  'sub_organization_id',  'archived_by',  'archived_at'
    ];
}
