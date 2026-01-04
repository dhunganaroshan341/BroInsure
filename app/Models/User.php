<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Notifications\AdminResetPasswordNotification;
use App\Traits\CreatedByTrait;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CreatedByTrait;
    const DELETED_AT = 'archived_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'mobilenumber',
        'countrycode',
        'email',
        'password',
        'usertype',
        'profile_pic',
        'designation_id',
        'last_login',
        'default_password',
        'created_by',
        'updated_by',
        'organization_id',
        'sub_organization_id',
        'archived_by',
        'archived_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public function setFnameAttribute($value)
    {
        $this->attributes['fname'] = $value ? ucfirst(strtolower($value)) : null;
    }
    public function setMnameAttribute($value)
    {
        $this->attributes['mname'] = $value ? ucfirst(strtolower($value)) : null;
    }
    public function setLnameAttribute($value)
    {
        $this->attributes['lname'] = $value ? ucfirst(strtolower($value)) : null;
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute()
    {
        return $this->attributes['fname'] . ' ' . $this->attributes['lname'];
    }

    public function userType()
    {
        return $this->belongsTo(Usertype::class, 'usertype');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }
}
