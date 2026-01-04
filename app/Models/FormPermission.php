<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPermission extends Model
{
    use HasFactory;
    protected $fillable = ['formname','slug','isinsert','isupdate','isedit','isdelete','usertypeid'];

    protected $table = "form_permission";

}
