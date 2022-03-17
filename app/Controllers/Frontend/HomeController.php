<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\EventSimposiumModel;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ProvinsiModel;
use App\Models\SimposiumModel;
use App\Models\ValidasiModel;
use App\Models\WorkshopModel;
use Config\Services;

use Exception;
use CodeIgniter\Files\File;

class HomeController extends BaseController
{
    public function index()
    {
        return redirect()->to('/daftar');
    }
}