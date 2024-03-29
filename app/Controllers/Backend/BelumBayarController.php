<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ValidasiModel;
use App\Models\WorkshopModel;
use App\Models\PendaftaranJenisKamarHotelModel;


class PendaftaranController extends BaseController
{

    public function __construct()
    {
        $this->mValidasi = new ValidasiModel();
        $this->mPendaftaran = new PendaftaranModel();
        $this->mPendaftaranWorkshop = new PendaftaranWorkshopModel();
    }
    public function index()
    {
        return view('backend/belum-bayar/index');
    }

    public function detail($id)
    {
        $data = $this->mPendaftaran->getDetail($id);
        $workshops = $this->mPendaftaranWorkshop->getByIdPendaftaran($id);
        $penginapan = $this->mPendaftaranJenisKamarHotel->getByIdPendaftaran($id);

        $D = [
            'data' => $data,
            'workshops' => $workshops,
            'penginapan' => $penginapan,

        ];

        return view('backend/belum-bayar/detail', $D);
    }

    public function jsonPendaftaran()
    {
        $mPendaftaran = new PendaftaranModel();
        echo $mPendaftaran->jsonPendaftaran();
    }
}
