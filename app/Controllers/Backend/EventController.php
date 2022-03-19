<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    public function index()
    {
        return view('backend/event/index');
    }

    public function jsonEvent()
    {
        $model = new EventModel();
        echo $model->jsonEvent();
    }

    public function detail($id)
    {
    }

}
