<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\EventSimposiumModel;

class EventSimposiumController extends BaseController
{
    public function index()
    {
        return view('backend/event-simposium/index');
    }


    public function jsonDT()
    {
        $model = new EventSimposiumModel();

        echo $model->getAll();
    }
}
