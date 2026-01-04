<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
/**
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $status
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 *
 */
class FiscalYear extends Model  implements Auditable
{
    use HasFactory,CreatedByTrait;

    use \OwenIt\Auditing\Auditable;
    // const DELETED_AT = 'archived_at';
    const STATUS_YES = 'Y';
    const STATUS_NO = 'N';

    const STATUS_ALL = [ self::STATUS_YES, self::STATUS_NO ];

    protected $guarded = ["id"];
}
