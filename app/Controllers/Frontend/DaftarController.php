<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\EventSimposiumModel;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ProvinsiModel;
use App\Models\WorkshopModel;

class DaftarController extends BaseController
{
    public function index()
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
                // 'id_workshop' => [
                //     'label' => 'Workshop', 'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ],
                // ],
            ]);
            try {
                $this->db = \Config\Database::connect();

                $this->db->transBegin();
                $mPendaftaran = new PendaftaranModel();

                if (!$validation->withRequest($this->request)->run()) {
                    $errors += $validation->getErrors();
                }

                if ($mPendaftaran->isEmailUsed($this->request->getPost('email'))) {
                    $errors += ['email' => 'Email telah terdaftar'];
                }

                $mEventSimposium = new EventSimposiumModel();
                $simposium = $mEventSimposium->where('event_simposium.id', $this->request->getPost('id_event_simposium'))
                    ->join('simposium', 'event_simposium.id_simposium = simposium.id')
                    ->first();

                if (empty($simposium)) {
                    $errors += ['id_event_simposium' => 'Event tidak ditemukan'];
                }

                $mWorkshop = new WorkshopModel();
                $postIdWorkshops = $this->request->getPost('id_workshop') ?? [];

                foreach ($postIdWorkshops as $k => $v) {
                    $workshopAda = $mWorkshop->withTerpakai($v);
                    if ($workshopAda) {
                        if ($workshopAda['terpakai'] >= $workshopAda['kuota']) {
                            $errors += ['id_workshop_penuh_' . $k => "Workshop $workshopAda[pelatihan] penuh"];
                        }
                    } else {
                        $errors += ['id_workshop_kosong_' . $k => "Workshop dengan ID $v tidak ditemukan"];
                    }
                }

                if (!empty($errors)) {
                    throw new \Exception();
                }

                $tanggal_lahir = \DateTime::createFromFormat('d/m/Y', $this->request->getPost('tanggal_lahir'));
                $tanggal_lahir =  $tanggal_lahir->format('Y-m-d');
                $emailPendaftar = $this->request->getPost('email');

                $post = [
                    'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
                    'nama' => $this->request->getPost('nama'),
                    'tanggal_lahir' => $tanggal_lahir,
                    'institusi' => $this->request->getPost('institusi'),
                    'kota' => $this->request->getPost('kota'),
                    'provinsi' => $this->request->getPost('provinsi'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'email' => $this->request->getPost('email'),
                    'biaya' => $this->request->getPost('biaya'),
                    'id_event_simposium' => $this->request->getPost('id_event_simposium'),
                    'kode_unik_pembayaran' => $this->request->getPost('kode_unik_pembayaran')

                ];

                $idPendaftaran = $mPendaftaran->insert($post);

                $post['id'] = $idPendaftaran;
                $mPendftaranWoarkshop = new PendaftaranWorkshopModel();

                foreach ($postIdWorkshops as $k => $v) {
                    $postPendaftaranWorkshop = [
                        'id_pendaftaran' => $idPendaftaran,
                        'id_workshop' => $v,
                    ];
                    $insertWorkshop =  $mPendftaranWoarkshop->insert($postPendaftaranWorkshop);
                }

                $workshops = [];
                if ($postIdWorkshops) {
                    $workshops = $mWorkshop->whereIn('id', $postIdWorkshops)->findAll();
                }

                $settings = $this->db->table('settings')
                    ->where('param', 'durasi_pembayaran')
                    ->get()->getRowArray();

                $dataSukses = [
                    'workshops' => $workshops,
                    'simposium' => $simposium,
                    'pendaftaran' => $post,
                    'settings' => $settings,
                ];
                $this->session->setFlashdata('dataSukses', $dataSukses);

                $response =
                    [
                        'success' => true,
                        'message' => 'Berhasil mendaftar',
                        'redirect' => current_url(),
                    ];

                $template = view('frontend/daftar/template_email', $dataSukses);
                $sendMail = sendMail($emailPendaftar, "KOGI XVIII PEKANBARU 2022", "PENDFTARAN KOGI XVIII PEKANBARU 2022", $template);

                if ($sendMail['success']) {
                    $mPendaftaran->where('id', $idPendaftaran)
                        ->set('status_email_pendaftaran', 1)
                        ->update();
                }

                $this->db->transCommit();
            } catch (\Throwable $th) {
                $message = "Terdapat kesalahan";

                $exception = $th->getMessage();
                if (!empty($exception)) {
                    $errors += ['exception' => $exception];
                }
                

                $formMessage = "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
                $html = alert('error', "<b>Terdapat kesalahan</b>$formMessage");
                $response =
                    [
                        'success' => false,
                        'message' => $message,
                        'form_message' => $html,
                        'raw_errors' => $errors,
                    ];

                $this->db->transRollback();
            }

            return $this->response->setJSON($response);
        }

        if ($flashdata = $this->session->getFlashdata('dataSukses')) {

            $D = [
                'data' => $flashdata,
            ];
            return view('frontend/daftar/daftar_sukses', $D);
        }

        $sekarang = date('Y-m-d H:i:s');

        $mEventSimposium = new EventSimposiumModel();
        $mEventSimposium->where('mulai_pendaftaran <=', $sekarang);
        $mEventSimposium->where('selesai_pendaftaran >=', $sekarang);
        $mEventSimposium->join('simposium s', 'event_simposium.id_simposium = s.id');
        $eventSimposium = $mEventSimposium->findAll();

        $mWorkshop = new WorkshopModel();
        $mWorkshop->select("workshop.*, (SELECT COUNT(*) FROM pendaftaran_workshop pw WHERE pw.id_workshop = workshop.id) as terpakai");
        $workshop = $mWorkshop->where('active', '1')->findAll();

        $modelProvinsi = new ProvinsiModel();
        $provinsi = $modelProvinsi->findAll();

        $digits = 3;
        $kodeUnik = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $D = [
            'eventSimposium' => $eventSimposium,
            'workshop' => $workshop,
            'kode_unik' => $kodeUnik,
            'provinsi' => $provinsi,
        ];
        return view('frontend/daftar/index', $D);
    }
}
