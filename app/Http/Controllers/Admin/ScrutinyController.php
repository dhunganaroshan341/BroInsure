<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ScrutinyController extends BaseController
{
    public function index()
    {
        return view("backend.scrutiny.show", [
            "title" => "Scrutiny",
            "access" => $this->accessCheck('claimsubmissions')
        ]);
    }
}
