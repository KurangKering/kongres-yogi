<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\EventSimposiumModel;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\SimposiumModel;
use App\Models\WorkshopModel;

class HomeController extends BaseController
{
    public function index()
    {
        return redirect()->to('/daftar');
    }

    public function daftar()
    {

        if ($this->request->getMethod() == 'post') {

            $message = null;
            $errors = [];

            $validation =  \Config\Services::validation();

            $validation->setRules([
                'nama' => [
                    'label' => 'Nama', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'tanggal_lahir' => [
                    'label' => 'Tanggal lahir', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'institusi' => [
                    'label' => 'Institusi', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kota' => [
                    'label' => 'Kota', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'provinsi' => [
                    'label' => 'Provinsi', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'no_hp' => [
                    'label' => 'No HP', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'email' => [
                    'label' => 'Email', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'id_event_simposium' => [
                    'label' => 'Simposium', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'id_workshop' => [
                    'label' => 'Workshop', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);
            try {
                $this->db = \Config\Database::connect();

                $this->db->transBegin();

                if (!$validation->withRequest($this->request)->run()) {
                    $errors += $validation->getErrors();
                    throw new \Exception();
                }




                $post = [
                    'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
                    'nama' => $this->request->getPost('nama'),
                    'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                    'institusi' => $this->request->getPost('institusi'),
                    'kota' => $this->request->getPost('kota'),
                    'provinsi' => $this->request->getPost('provinsi'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'email' => $this->request->getPost('email'),
                    'biaya' => $this->request->getPost('biaya'),
                    'id_event_simposium' => $this->request->getPost('id_event_simposium'),
                    'kode_unik_pembayaran' => $this->request->getPost('kode_unik_pembayaran')

                ];


                $modelEventSimposium = new EventSimposiumModel();
                $simposium = $modelEventSimposium->where('event_simposium.id', $post['id_event_simposium'])
                    ->join('simposium', 'event_simposium.id_simposium = simposium.id')
                    ->first();


                if (empty($simposium)) {
                    $errors += ['id_event_simposium' => 'Event tidak ditemukan'];
                    throw new \Exception();
                }


                $modelPendaftaran = new PendaftaranModel();

                $insertPendaftaran = $modelPendaftaran->insert($post);

                if (!$insertPendaftaran) {

                    $errors += ['exception' => 'Tidak dapat menyimpan data pendaftaran'];
                    throw new \Exception();
                }

                $id_pendaftaran = $insertPendaftaran;

                $modelPendaftaranWorkshop = new PendaftaranWorkshopModel();

                $workshops = $this->request->getPost('id_workshop');

                foreach ($workshops as $k => $v) {
                    $postPendaftaranWorkshop = [
                        'id_pendaftaran' => $id_pendaftaran,
                        'id_workshop' => $v,
                    ];

                    $insertWorkshop =  $modelPendaftaranWorkshop->insert($postPendaftaranWorkshop);
                }

                $this->db->transCommit();


                $response =
                    [
                        'success' => true,
                        'message' => 'Berhasil mendaftar',
                        'redirect' => '',
                    ];
                return $this->response->setJSON($response);
            } catch (\Throwable $th) {

                $message = "Terdapat kesalahan";


                if ($th->getCode() == '1062') {
                    $errors += ['email' => 'Email telah terdaftar'];
                } else if (!empty($th->getCode())) {
                    $errors += ['exception' => $th->getMessage()];
                }

                $this->db->transRollback();

                $response =
                    [
                        'success' => false,
                        'message' => $message,
                        'form_message' => $errors,
                    ];


                return $this->response->setJSON($response);
            }
        }


        $sekarang = date('Y-m-d H:i:s');

        $modelEventSimposium = new EventSimposiumModel();
        $modelEventSimposium->where('mulai_pendaftaran <=', $sekarang);
        $modelEventSimposium->where('selesai_pendaftaran >=', $sekarang);
        $modelEventSimposium->join('simposium s', 'event_simposium.id_simposium = s.id');
        $eventSimposium = $modelEventSimposium->findAll();

        $modelWorkshop = new WorkshopModel();
        $workshop = $modelWorkshop->where('active', '1')->findAll();

        $digits = 3;
        $kodeUnik = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $D = [
            'eventSimposium' => $eventSimposium,
            'workshop' => $workshop,
            'kode_unik' => $kodeUnik,
        ];

        return view('frontend/pendaftaran', $D);
    }

    public function validasi()
    {
        return view('frontend/validasi');
    }
}
