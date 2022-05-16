<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\HotelModel;

class HotelController extends BaseController
{
    public function index()
    {
    return view('backend/hotel/index');
    }

    public function jsonHotel()
    {
        $model = new HotelModel();
        echo $model->jsonHotel();
    }

    public function detail($id)
    {
    }
}
