<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;

class ValidasiController extends BaseController
{
    public function index()
    {
        return view('backend/validasi/index');
    }

    public function jsonDT()
    {
        $model = new PendaftaranModel();

        echo $model->getAllValidasi();
    }
}
