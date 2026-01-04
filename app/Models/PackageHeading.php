<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PackageHeading extends Model implements Auditable
{
    use HasFactory, CreatedByTrait;

    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = "package_headings";

}
