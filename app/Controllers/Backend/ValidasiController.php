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

    public function jsonValidasiSudahBayar()
    {
        echo $this->mValidasi->jsonValidasiSudahBayar();
    }

    public function validasi()
    {
        $post = $this->request->getPost();

        $this->mPendaftaran->where('id_pendaftaran', $post['id']);
        $pendaftaran = $this->mPendaftaran->first();

        $this->db = \Config\Database::connect();
        $response = [];

        if ($post['status'] == 1) {

            $postUpdate = [
                'status' => 'sukses',
            ];
            $update = $this->mPendaftaran->update($post['id'], $postUpdate);

            if ($update) {

                $updateValidasi = $this->mValidasi->where('id_pendaftaran', $post['id'])
                    ->set('tanggal_verifikasi', date('Y-m-d H:i:s'))
                    ->update();

                $content = [
                    'pendaftaran' => $pendaftaran,
                    'id_pendaftaran' => $post['id'],
                ];
                $template = view('backend/validasi/template_email', $content);
                $send = sendMail($pendaftaran['email'], "KOGI XVIII PEKANBARU 2022", "PENDFTARAN KOGI XVIII PEKANBARU 2022", $template);

                if ($send['success']) {
                    $this->mValidasi->where('id_pendaftaran', $post['id'])
                        ->set('status_email_verifikasi', 1)
                        ->update();
                }

                $response = [
                    'success' => true,
                    'message' => 'Data berhasil diverifikasi',
                ];
            }
        } else if ($post['status'] == 0) {
            $data = $this->mPendaftaran->getDetail($post['id']);
            $delete = $this->mPendaftaran->where('id_pendaftaran', $post['id'])->delete();
            if ($delete) {

                if (!empty($data['file'])) {
                    $filePath = WRITEPATH . 'uploads' . '/' . $data['file'];
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil ditolak',
                ];
            }
        }

        return $this->response->setJSON($response);
    }

    public function renderVerifikasi()
    {

        $D = [];
        return view('backend/validasi/render-verifikasi', $D);
    }
}
