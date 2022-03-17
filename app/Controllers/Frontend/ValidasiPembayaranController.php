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

class ValidasiPembayaranController extends BaseController
{
    public function index()
    {
        if ($this->request->getMethod() == 'post') {

            $message = null;
            $errors = [];

            $validation =  \Config\Services::validation();

            $rules = [
                'id_pendaftaran' => [
                    'label' => 'No. Pendaftaran', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ];

            $is_f_validasi = isset($_FILES['file']);
            $is_f_validasi = $is_f_validasi ? !empty($_FILES['file']['tmp_name']) : false;
            $f_validasi = $is_f_validasi ? $_FILES['file'] : null;

            if (!$is_f_validasi) {

                $rules += [
                    'file' => [
                        'label' => 'Bukti Pembayaran', 'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                ];
            } else {
                if (empty(strstr($f_validasi['type'], 'image/'))) {
                    $rules += [
                        'file_type' => [
                            'label' => 'Bukti Pembayaran', 'rules' => 'required',
                            'errors' => [
                                'required' => '{field} harus berformat JPG atau PNG',
                            ],
                        ],
                    ];
                }
                if ($f_validasi['size'] > 1024000) {
                    $rules += [
                        'file_size' => [
                            'label' => 'Bukti Pembayaran', 'rules' => 'required',
                            'errors' => [
                                'required' => '{field} maksimal berukuran 1 MB',
                            ],
                        ],
                    ];
                }
            }

            $validation->setRules($rules);

            try {
                $this->db = \Config\Database::connect();

                if (!$validation->withRequest($this->request)->run()) {
                    $errors += $validation->getErrors();
                    throw new \Exception();

                }

                $idPendaftaran = $this->request->getPost('id_pendaftaran');

                $modelPendaftaran = new PendaftaranModel();
                $modelPendaftaran->join('validasi', 'pendaftaran.id = validasi.id_pendaftaran', 'LEFT');
                $pendaftaran = $modelPendaftaran->find($idPendaftaran);

                if (empty($pendaftaran)) {
                    $errors += [
                        'id_pendaftaran' => 'No. Pendaftaran tidak ditemukan',
                    ];
                    throw new \Exception();
                }

                if (!empty($pendaftaran['id_pendaftaran'])) {
                    $errors += [
                        'id_pendaftaran' => 'Bukti pembayaran telah ada',
                    ];
                    throw new \Exception();
                }

                $img = $this->request->getFile('file');
                $newName = $img->getRandomName();

                if (!$img->hasMoved()) {
                    $img->move(WRITEPATH . 'uploads', $newName);
                }

                if (!empty($img->getError())) {
                    $errors += [
                        'file' => uploadErrors($img->getError()),
                    ];
                    throw new \Exception();
                }

                $this->db->transBegin();

                $modelValidasi = new ValidasiModel();
                $postValidasi = [
                    'id_pendaftaran' => $idPendaftaran,
                    'tanggal_validasi' => date('Y-m-d H:i:s'),
                    'file' => $newName,
                ];

                $modelValidasi->insert($postValidasi);


                $updatePendaftaran = $this->db->table('pendaftaran')
                    ->where('id', $idPendaftaran)
                    ->update(['status' => 'sudah_bayar']);


                $this->db->transCommit();
                $modelPendaftaran->select('pendaftaran.*, validasi.tanggal_validasi, file, status_email_verifikasi');
                $modelPendaftaran->join('validasi', 'pendaftaran.id = validasi.id_pendaftaran', 'LEFT');
                $pendaftaran = $modelPendaftaran->find($idPendaftaran);


                $dataSukses = [
                    'pendaftaran' => $pendaftaran,
                ];
                $this->session->setFlashdata('dataSuksesValidasi', $dataSukses);

                $response =
                    [
                        'success' => true,
                        'message' => "Berhasil melakukan validasi pembayaran",
                        'redirect' => current_url(),
                    ];
            } catch (\Throwable $th) {
                $message = "Terdapat kesalahan";
                $exception = $th->getMessage();
                if (!empty($exception)) {
                    $errors += ['exception' => $exception];
                }

                $errors = "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
                $html = alert('error', "<b>Terdapat kesalahan</b>$errors");

                $response =
                    [
                        'success' => false,
                        'message' => $message,
                        'form_message' => $html,
                    ];

                $this->db->transRollback();
            }
            return $this->response->setJSON($response);
        }

        if ($flashdata = $this->session->getFlashdata('dataSuksesValidasi')) {
            $D = [
                'data' => $flashdata,
            ];
            return view('frontend/validasi-pembayaran/validasi-pembayaran-sukses', $D);
        }

        return view('frontend/validasi-pembayaran/index');
    }
}
