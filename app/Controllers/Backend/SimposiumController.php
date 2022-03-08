<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\SimposiumModel;

class SimposiumController extends BaseController
{
    public function index()
    {
        return view('backend/simposium/index');
    }


    public function jsonDT()
    {
        $model = new SimposiumModel();

        echo $model->getAll();
    }
}
