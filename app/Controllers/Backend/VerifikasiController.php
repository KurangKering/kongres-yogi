<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ValidasiModel;
use App\Models\PendaftaranJenisKamarHotelModel;


class VerifikasiController extends BaseController
{

    public function __construct()
    {
        $this->mPendaftaran = new PendaftaranModel();
        $this->mValidasi = new ValidasiModel();
        $this->mPendaftaranWorkshop = new PendaftaranWorkshopModel();
        $this->mPendaftaranJenisKamarHotel = new PendaftaranJenisKamarHotelModel();
    }
    public function index()
    {
        return view('backend/verifikasi/index');
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
        return view('backend/verifikasi/detail', $D);
    }

    public function jsonVerifikasi()
    {
        echo $this->mValidasi->jsonVerifikasi();
    }
}
