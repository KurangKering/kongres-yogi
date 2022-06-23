<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\ValidasiModel;

class MenuLainController extends BaseController
{

    public function __construct()
    {
        $this->mPendaftaran = new PendaftaranModel();
        $this->mValidasi = new ValidasiModel();
    }
    public function index()
    {
        return view('frontend/menu-lain/index');
    }

    public function cek()
    {
        $idPendaftaran = $this->request->getPost('id_pendaftaran');
        $pendaftaran = $this->mPendaftaran->getDetail($idPendaftaran);

        $errors = null;
        if (empty($pendaftaran)) {
            $errors = "Data tidak ditemukan";
        } else {
            if ($pendaftaran['status'] == 'belum_bayar') {
                $errors = "Data pendaftaran belum melakukan pembayaran";
            } else if ($pendaftaran['status'] == 'sudah_bayar') {
                $errors = "Data pendaftaran sedang diproses";
            } else if ($pendaftaran['status'] == 'gagal') {
                $errors = "Data pendaftaran ditolak";
            }
        }

        if (empty($errors)) {
            $response['success'] = true;
            $response['message'] = '';
            $response['redirect'] = "https://google.com";
        } else {
            $response['success'] = false;
            $response['message'] = $errors;
        }

        return $this->response->setJSON($response);
    }
}
