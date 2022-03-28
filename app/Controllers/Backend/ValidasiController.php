<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ValidasiModel;

class ValidasiController extends BaseController
{

    public function __construct()
    {
        $this->mValidasi = new ValidasiModel();
        $this->mPendaftaran = new PendaftaranModel();
        $this->mPendaftaranWorkshop = new PendaftaranWorkshopModel();
    }
    public function index()
    {
        return view('backend/validasi/index');
    }

    public function detail($id)
    {
        $data = $this->mPendaftaran->getDetail($id);
        $workshops = $this->mPendaftaranWorkshop->getByIdPendaftaran($id);

        $D = [
            'data' => $data,
            'workshops' => $workshops,
        ];

        return view('backend/validasi/detail', $D);
    }

    private function detailDiterima($id)
    {
    }

    public function json($tipe)
    {
        switch ($tipe) {
            case 'menunggu':
                echo $this->mValidasi->jsonMenunggu();
                break;
            case 'diterima':
                echo $this->mValidasi->jsonDiterima();
                break;

            case 'ditolak';
                echo $this->mValidasi->jsonDitolak();
                break;
            default:
                break;
        }
    }

    public function validasi()
    {
        $post = $this->request->getPost();

        $idValidasi = $post['id'];
        $pendaftaran = $this->mValidasi->getDetail($idValidasi);

        $this->db = \Config\Database::connect();
        $response = [];
        $message = '';

        $postUpdatePendaftaran = [];
        $postUpdateValidasi = ['tanggal_verifikasi' => date('Y-m-d H:i:s')];
        $templateEmail = '';

        if ($post['status'] == 'sukses') {
            $postUpdatePendaftaran = ['status' => 'sukses'];
            $postUpdateValidasi += ['alasan_penolakan' => null];
            $templateEmail = 'backend/validasi/template_email_validasi_diterima';
            $message = 'Data berhasil diterima';
        } else if ($post['status'] == 'gagal') {
            $postUpdatePendaftaran = ['status' => 'gagal'];
            $postUpdateValidasi += ['alasan_penolakan' => $post['alasan-penolakan']];
            $templateEmail = 'backend/validasi/template_email_validasi_ditolak';
            $message = 'Data berhasil ditolak';
        }

        $updateP = $this->mPendaftaran->update($pendaftaran['id_pendaftaran'], $postUpdatePendaftaran);
        if ($updateP) {
            $updateV = $this->mValidasi->update($idValidasi, $postUpdateValidasi);
            $pendaftaran['alasan_penolakan'] = $post['alasan-penolakan'] ?? null;
            $content = [
                'pendaftaran' => $pendaftaran,
            ];
            $template = view($templateEmail, $content);
            $send = sendMail($pendaftaran['email'], "KOGI XVIII PEKANBARU 2022", "PENDFTARAN KOGI XVIII PEKANBARU 2022", $template);
            if ($send['success']) {
                $this->mValidasi->where('id_validasi', $idValidasi)
                    ->set('status_email_verifikasi', 1)
                    ->update();
            } else {
                $this->mValidasi->where('id_validasi', $idValidasi)
                    ->set('status_email_verifikasi', 0)
                    ->update();
            }
            $response = [
                'success' => true,
                'message' => $message,
                'icon' => 'success'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Terdapat kesalahan saat menyimpan data',
                'icon' => 'alert'

            ];
        }

        return $this->response->setJSON($response);
    }

    public function modalValidasi($id)
    {

        $data = $this->mPendaftaran->getDetail($id);
        $D = [
            'data' => $data,
        ];
        return view('backend/validasi/modal-validasi', $D);
    }

    public function sendMail($tipe)
    {
        $id = $this->request->getPost('id');

        $templateEmail = '';
        switch ($tipe) {
            case 'diterima':
                $templateEmail = 'backend/validasi/template_email_validasi_diterima';
                break;
            case 'ditolak':
                $templateEmail = 'backend/validasi/template_email_validasi_ditolak';
            default:
                break;
        }

        $pendaftaran = $this->mPendaftaran->getDetail($id);
        $content = [
            'pendaftaran' => $pendaftaran,
        ];

        $response = [];
        $template = view($templateEmail, $content);
        $send = sendMail($pendaftaran['email'], "KOGI XVIII PEKANBARU 2022", "PENDFTARAN KOGI XVIII PEKANBARU 2022", $template);
        if ($send['success']) {
            $this->mValidasi->where('id_validasi', $pendaftaran['id_validasi'])
                ->set('status_email_verifikasi', 1)
                ->update();
            $message = "Email berhasil dikirim";
            $success = true;

            $response = [
                'success' => true,
                'message' => 'Email berhasil dikirim',
                'icon' => 'success',
            ];
        } else {
            $this->mValidasi->where('id_validasi', $pendaftaran['id_validasi'])
                ->set('status_email_verifikasi', 0)
                ->update();
            $response = [
                'success' => false,
                'message' => 'Email gagal dikirim' .  json_encode($send),
                'icon' => 'alert',
            ];
        }
        return $this->response->setJSON($response);
    }
}
