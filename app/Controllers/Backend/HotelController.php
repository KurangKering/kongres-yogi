<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\HotelModel;
use App\Models\JenisKamarHotelModel;

class HotelController extends BaseController
{
    public function __construct()
    {
        $this->mJenisKamarHotel = new JenisKamarHotelModel();
    }
    public function index()
    {
        return view('backend/hotel/index');
    }

    public function jsonHotel()
    {
        $model = new HotelModel();
        echo $model->jsonHotel();
    }

    public function listTerpakai($id)
    {
        $data = $this->mJenisKamarHotel->getListTerpakai($id);
        $D = [
            'data' => $data
        ];
        echo view('backend/hotel/list-terpakai', $D);
    }
}
