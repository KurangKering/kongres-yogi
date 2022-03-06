<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class SimposiumController extends BaseController
{
    public function index()
    {
        return view('backend/simposium/index');
    }
}
