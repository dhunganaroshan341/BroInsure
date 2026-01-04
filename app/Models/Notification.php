<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'notification_date',
        'message',
        'type',
        'redirect_url',
        'user_id',
        'is_seen',
        'created_by',
        'updated_by',
        'organization_id',
        'sub_organization_id',
        'archived_by',
        'archived_at'
    ];
}
