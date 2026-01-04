<?php

namespace App\Models;

use App\Http\Controllers\BaseController;
use App\Services\MicrosoftTeamService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAttachment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function removeFile()
    {
        app(BaseController::class)->removePublicFile('admin/' . $this->file_name);
    }

    public function getFileUrlAttribute()
    {
        return config('app.url') . "/admin/$this->file_name";
    }
}
