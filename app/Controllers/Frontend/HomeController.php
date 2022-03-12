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
use Exception;
use CodeIgniter\Files\File;

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
                $post['id'] = $id_pendaftaran;

                $modelPendaftaranWorkshop = new PendaftaranWorkshopModel();

                $postIdWorkshops = $this->request->getPost('id_workshop');

                foreach ($postIdWorkshops as $k => $v) {
                    $postPendaftaranWorkshop = [
                        'id_pendaftaran' => $id_pendaftaran,
                        'id_workshop' => $v,
                    ];

                    $insertWorkshop =  $modelPendaftaranWorkshop->insert($postPendaftaranWorkshop);
                }
                $workshops = $this->db->table('workshop')->whereIn('id', $postIdWorkshops)->get()->getResultArray();

                $dataSukses = [
                    'workshops' => $workshops,
                    'simposium' => $simposium,
                    'pendaftaran' => $post,
                ];

                $this->session->setFlashdata('dataSukses', $dataSukses);

                $response =
                    [
                        'success' => true,
                        'message' => 'Berhasil mendaftar',
                        'redirect' => current_url(),
                    ];

                $this->db->transCommit();

                $mailMessage = 'Pendaftaran berhasil';
                $sendMail = sendMail($emailPendaftar, "Pendaftaran KOGI", "Pendaftaran KOGI", $mailMessage);
                if ($sendMail) {
                    $updatePendaftaran = $this->db->table('pendaftaran')
                        ->where('id', $id_pendaftaran)
                        ->update(['status_email_pendaftaran' => 1]);
                }
            } catch (\Throwable $th) {
                $message = "Terdapat kesalahan";
                if ($th->getCode() == '1062') {
                    $errors += ['email' => 'Email telah terdaftar'];
                } else if (!empty($th->getCode())) {
                    $errors += ['exception' => $th->getMessage()];
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

        if ($flashdata = $this->session->getFlashdata('dataSukses')) {

            $D = [
                'data' => $flashdata,
            ];
            return view('frontend/daftar_sukses', $D);
        }

        $sekarang = date('Y-m-d H:i:s');

        $modelEventSimposium = new EventSimposiumModel();
        $modelEventSimposium->where('mulai_pendaftaran <=', $sekarang);
        $modelEventSimposium->where('selesai_pendaftaran >=', $sekarang);
        $modelEventSimposium->join('simposium s', 'event_simposium.id_simposium = s.id');
        $eventSimposium = $modelEventSimposium->findAll();

        $modelWorkshop = new WorkshopModel();
        $modelWorkshop->select("workshop.*, (SELECT COUNT(*) FROM pendaftaran_workshop pw WHERE pw.id_workshop = workshop.id) as terpakai");
        $workshop = $modelWorkshop->where('active', '1')->findAll();

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
        return view('frontend/daftar', $D);
    }

    private function daftarSukses()
    {
        return view('frontend/daftar_sukses');
    }

    public function validasiPembayaran()
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

                $this->db->transCommit();
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

                $exceptionMessage = $th->getMessage();

                if ($exceptionMessage !== '') {
                    $errors += ['exception' => $th->getMessage()];
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
            return view('frontend/validasi-pembayaran-sukses', $D);
        }

        return view('frontend/validasi-pembayaran');
    }

    public function testSendMail($email)
    {
        $send = sendMail($email, "Tes Email", "Tes Email", "Tes Email");
        dd($send);
    }
}
