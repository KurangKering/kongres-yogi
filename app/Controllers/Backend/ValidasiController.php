<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\ValidasiModel;

class ValidasiController extends BaseController
{
    public function index()
    {
        return view('backend/validasi/index');
    }

    public function detail()
    {
        echo '';
    }

    public function jsonValidasiSudahBayar()
    {
        $mValidasi = new ValidasiModel();
        echo $mValidasi->jsonValidasiSudahBayar();
    }

    public function validasi()
    {
        $post = $this->request->getPost();

        $mPendaftaran = new PendaftaranModel();
        $mValidasi = new ValidasiModel();

        $mPendaftaran->where('id', $post['id']);
        $pendaftaran = $mPendaftaran->first();

        $this->db = \Config\Database::connect();
        $response = [];

        if ($post['status'] == 1) {

            $postUpdate = [
                'status' => 'sukses',
                'tanggal_verifikasi' => date('Y-m-d'),
            ];
            $update = $mPendaftaran->update($post['id'], $postUpdate);

            if ($update) {
                $content = [
                    'pendaftaran' => $pendaftaran,
                    'id' => $post['id'],
                ];
                $template = view('backend/validasi/template_email', $content);
                $send = sendMail($pendaftaran['email'], "KOGI XVIII PEKANBARU 2022", "PENDFTARAN KOGI XVIII PEKANBARU 2022", $template);

                if ($send['success']) {
                    $mValidasi->where('id_pendaftaran', $post['id'])
                        ->set('status_email_verifikasi', 1)
                        ->update();
                }

                $response = [
                    'success' => true,
                    'messsage' => 'Data berhasil divalidasi',
                ];
            }
        } else if ($post['status'] == 0) {
            $delete = $mPendaftaran->where('id', $post['id'])->delete();
            if ($delete) {
                $response = [
                    'success' => true,
                    'messsage' => 'Data berhasil ditolak',
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
