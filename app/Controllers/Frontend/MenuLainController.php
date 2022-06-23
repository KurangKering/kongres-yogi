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
                $errors = "Peserta belum melakukan pembayaran";
            } else if ($pendaftaran['status'] == 'sudah_bayar') {
                $errors = "Data peserta sedang diproses";
            } else if ($pendaftaran['status'] == 'gagal') {
                $errors = "Data peserta ditolak";
            }
        }

        if (empty($errors)) {
            $response['success'] = true;
            $response['message'] = '';
            $response['redirect'] = "https://us02web.zoom.us/j/81160159838?pwd=M2I70Z3dfXrRf70onGElUZLwlOuqOM.1";
        } else {
            $response['success'] = false;
            $response['message'] = $errors;
        }

        return $this->response->setJSON($response);
    }
}
