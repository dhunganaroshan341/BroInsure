<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;
    //Which fileds are going to filed on the login form 
    protected $fillable = [
        'email',
        'password',
    ];
    //Hidden Fields (Password) for protecting your admin's data
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //Admin Model
    protected $table = "users";
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}