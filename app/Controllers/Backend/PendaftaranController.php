<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;

class PendaftaranController extends BaseController
{
    public function index()
    {
        return view('backend/pendaftaran/index');
    }

    public function jsonDT()
    {
        $model = new PendaftaranModel();

        echo $model->getAll();
    }
}
