<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\EventSimposiumModel;
use App\Models\HotelModel;
use App\Models\JenisKamarHotelModel;
use App\Models\PendaftaranJenisKamarHotelModel;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ProvinsiModel;
use App\Models\WorkshopModel;
use DateInterval;
use DatePeriod;
use DateTime;

class DaftarController extends BaseController
{
    public function __construct()
    {
        $this->mPendaftaran = new PendaftaranModel();
        $this->mHotel = new HotelModel();
        $this->mJenisKamarHotel = new JenisKamarHotelModel();
        $this->mPendaftaranJenisKamarHotel = new PendaftaranJenisKamarHotelModel();
        $this->mEventSimposium = new EventSimposiumModel();
        $this->mWorkshop = new WorkshopModel();
        $this->mPendftaranWorkshop = new PendaftaranWorkshopModel();
        $this->mProvinsi = new ProvinsiModel();
        $this->mJenisKamarHotel = new JenisKamarHotelModel();
    }
    public function index()
    {
        if ($this->request->getMethod() == 'post') {

            $message = null;
            $errors = [];
            $validation =  \Config\Services::validation();
            $pIdEventSimposium = $this->request->getPost('id_event_simposium');
            $pEmail = $this->request->getPost('email');
            $pIdWorkshops = $this->request->getPost('id_workshop') ?? [];
            $pSelectHotel = $this->request->getPost('select-hotel');
            $pSelectLamaMenginap = $this->request->getPost('select-lama-menginap');
            $pSelectJenisKamar = $this->request->getPost('select-jenis-kamar');
            $pSelectTanggalMenginap = $this->request->getPost('select-tanggal-menginap');
            $pBiaya = $this->request->getPost('biaya');
            $pKodeUnik = $this->request->getPost('kode_unik_pembayaran');

            $rules = [
                'nama' => [
                    'label' => 'Nama', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                // 'tanggal_lahir' => [
                //     'label' => 'Tanggal lahir', 'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ],
                // ],
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
                //'id_event_simposium' => [
                //    'label' => 'Simposium', 'rules' => 'required',
                //    'errors' => [
                //        'required' => '{field} tidak boleh kosong',
                //    ],
              //  ],
                'select-hotel' => [
                    'label' => 'Opsi Penginapan', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ];

            if (!empty($pSelectHotel)) {
                $rules['select-jenis-kamar'] = [
                    'label' => 'Jenis Kamar', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ];
            }

            if (!empty($pSelectJenisKamar)) {
                $rules['select-tanggal-menginap'] = [
                    'label' => 'Tanggal menginap', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ];
            }
            if (!empty($pSelectTanggalMenginap)) {
                $rules['select-lama-menginap'] = [
                    'label' => 'Lama menginap', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ];
            }

            $validation->setRules($rules);

            try {
                $this->db = \Config\Database::connect();
                $callback = [];

                $this->db->transBegin();

                if (!$validation->withRequest($this->request)->run()) {
                    $errors += $validation->getErrors();
                }

                if ($this->mPendaftaran->isEmailUsed($pIdEventSimposium, $pEmail)) {
                    $errors += ['email' => 'Email telah terdaftar'];
                }

                $simposium = $this->mEventSimposium->where('event_simposium.id_event_simposium', $pIdEventSimposium)
                    ->join('simposium', 'event_simposium.id_simposium = simposium.id_simposium')
                    ->first();

               // if (empty($simposium)) {
                //    $errors += ['id_event_simposium' => 'Event tidak ditemukan'];
               // }

                foreach ($pIdWorkshops as $k => $v) {
                    $workshopAda = $this->mWorkshop->withTerpakai($v);
                    if ($workshopAda) {
                        if ($workshopAda['terpakai'] >= $workshopAda['kuota']) {
                            $errors += ['id_workshop_penuh_' . $k => "Workshop $workshopAda[pelatihan] penuh"];
                        }
                    } else {
                        $errors += ['id_workshop_kosong_' . $k => "Workshop dengan ID $v tidak ditemukan"];
                    }
                }

                $isTanggalMenginapTersedia = true;

                if (!empty($pSelectLamaMenginap)) {
                    $idJenisKamarHotel = $pSelectJenisKamar;
                    $tanggalMenginapAwal = $pSelectTanggalMenginap;
                    $lamaMenginap = $pSelectLamaMenginap;
                    $perhitunganHari = $lamaMenginap - 1;
                    $tanggalMenginapAkhir = date("Y-m-d", strtotime($tanggalMenginapAwal . " + $perhitunganHari days"));

                    $begin = new DateTime($tanggalMenginapAwal);
                    $end = (new DateTime($tanggalMenginapAkhir))->modify('+1 day');


                    $interval = new DateInterval('P1D');
                    $period = new DatePeriod($begin, $interval, $end);



                    foreach ($period as $dt) {
                        $tanggal = $dt->format('Y-m-d');
                        if (!$this->mJenisKamarHotel->checkKetersediaanKamar($idJenisKamarHotel, $tanggal)) {
                            $isTanggalMenginapTersedia = false;
                            break;
                        }
                    }

                    if (!$isTanggalMenginapTersedia) {
                        $tanggalBentrok = date('d-m-Y', strtotime($tanggal));
                        $errors += ['tanggal_menginap' => "Tanggal $tanggalBentrok Sudah penuh"];
                        $jumlahHariBolehMenginap = $this->mJenisKamarHotel->getJumlahHariBolehMenginap($idJenisKamarHotel, $tanggalMenginapAwal);
                        $optionLamaMenginap = $this->mJenisKamarHotel->getOptionLamaMenginap($tanggalMenginapAwal, $jumlahHariBolehMenginap);
                        $callback['option_lama_menginap'] = $optionLamaMenginap;

                        if ($tanggal == $tanggalMenginapAwal) {
                            $tanggalTersedia = $this->mJenisKamarHotel->getTanggalTersedia($idJenisKamarHotel);
                            $callback['option_tanggal_menginap'] = $this->mJenisKamarHotel->getOptionTanggalMenginap($tanggalTersedia);
                        }
                    }
                }

                // validasi biaya
                if (empty($errors)) {
                    $totalPembayaranPembanding = 0;
                    $eventSimposium = $this->mEventSimposium->where('id_event_simposium', $pIdEventSimposium)->first();
                    $totalPembayaranPembanding += !empty($eventSimposium) ? $eventSimposium['harga'] : 0;
                    $workshops = [];
                    if (!empty($pIdWorkshops)) {
                        $workshops = $this->mWorkshop->whereIn('id_workshop', $pIdWorkshops)->findAll();
                        foreach ($workshops as $k => $workshop) {
                            $totalPembayaranPembanding += $workshop['biaya'];
                        }
                    }
                    $lamaMenginap = $pSelectLamaMenginap;
                    if (!empty($lamaMenginap)) {
                        $idJenisKamar = $pSelectJenisKamar;
                        $jenisKamar = $this->mJenisKamarHotel->where('id_jenis_kamar_hotel', $idJenisKamar)->first();
                        if (!empty($jenisKamar)) {
                            $totalPembayaranPembanding += $jenisKamar['harga'] * $lamaMenginap;
                        }
                    }
                    $pBiaya = $pBiaya;
                    $pKodeUnik = $pKodeUnik;
                    $totalPembayaranPembanding += $pKodeUnik;
                    $pTotalPembayaran = $pBiaya + $pKodeUnik;

                    if ($totalPembayaranPembanding != $pTotalPembayaran) {
                        $errors += ['total_pembayaran' => "Total pembayaran tidak sinkron"];
                    }
                }

                if (!empty($errors)) {
                    throw new \Exception();
                }

                // $tanggalLahir = \DateTime::createFromFormat('d/m/Y', $this->request->getPost('tanggal_lahir'));
                // $tanggalLahir =  $tanggalLahir->format('Y-m-d');
                $emailPendaftar = $pEmail;
                $totalPembayaran = $pBiaya + $pKodeUnik;


                $post = [
                    'tanggal_pendaftaran' => date('Y-m-d H:i:s'),
                    'nama' => $this->request->getPost('nama'),
                    // 'tanggal_lahir' => $tanggalLahir,
                    'institusi' => $this->request->getPost('institusi'),
                    'kota' => $this->request->getPost('kota'),
                    'provinsi' => $this->request->getPost('provinsi'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'email' => $pEmail,
                    'biaya' => $pBiaya,
                    'id_event_simposium' => $pIdEventSimposium,
                    'kode_unik_pembayaran' => $pKodeUnik,
                    'total_pembayaran' => $totalPembayaran,
                ];

                $idPendaftaran = $this->mPendaftaran->insert($post);

                $post['id_pendaftaran'] = $idPendaftaran;

                foreach ($pIdWorkshops as $k => $v) {
                    $postPendaftaranWorkshop = [
                        'id_pendaftaran' => $idPendaftaran,
                        'id_workshop' => $v,
                    ];
                    $insertWorkshop =  $this->mPendftaranWorkshop->insert($postPendaftaranWorkshop);
                }

                if ($isTanggalMenginapTersedia && !empty($pSelectLamaMenginap)) {
                    $period = new DatePeriod($begin, $interval, $end);
                    $harga = $this->mJenisKamarHotel->select('harga')->where('id_jenis_kamar_hotel', $idJenisKamarHotel)->first();
                    $harga = !empty($harga) ? $harga['harga'] : null;

                    foreach ($period as $dt) {
                        $postPendaftaranJenisKamarHotel = [
                            'id_pendaftaran' => $idPendaftaran,
                            'id_jenis_kamar_hotel' => $idJenisKamarHotel,
                            'tanggal' => $dt->format('Y-m-d'),
                            'harga' => $harga,
                        ];
                        $insertPendaftaranJenisKamarHotel = $this->mPendaftaranJenisKamarHotel->insert($postPendaftaranJenisKamarHotel);
                    }
                }

                $workshops = !empty($pIdWorkshops) ? $workshops = $this->mWorkshop->whereIn('id_workshop', $pIdWorkshops)->findAll() : [];
                $settings = $this->db->table('settings')
                    ->where('param', 'durasi_pembayaran')
                    ->get()->getRowArray();
                $pendaftaran = $this->mPendaftaran->getDetail($idPendaftaran);
                $penginapan = $this->mPendaftaranJenisKamarHotel->getByIdPendaftaran($idPendaftaran);

                $dataSukses = [
                    'workshops' => $workshops,
                    'simposium' => $simposium,
                    'pendaftaran' => $pendaftaran,
                    'settings' => $settings,
                    'penginapan' => $penginapan,
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
                    $this->mPendaftaran->where('id_pendaftaran', $idPendaftaran)
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


                $formMessage = "<div class=\"list-error\"><ul><li>" . implode("</li><li>", $errors) . "</li></ul></div>";
                $html = alert('error', "<b>Terdapat kesalahan</b>$formMessage");
                $response =
                    [
                        'success' => false,
                        'message' => $message,
                        'form_message' => $formMessage,
                        'raw_errors' => $errors,
                        'callback' => $callback,
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

        $this->mEventSimposium->where('mulai_pendaftaran <=', $sekarang);
        $this->mEventSimposium->where('selesai_pendaftaran >=', $sekarang);
        $this->mEventSimposium->join('simposium s', 'event_simposium.id_simposium = s.id_simposium');
        $eventSimposium = $this->mEventSimposium->findAll();

        $this->mWorkshop->select("workshop.*, (SELECT COUNT(*) FROM pendaftaran_workshop pw WHERE pw.id_workshop = workshop.id_workshop) as terpakai");
        $workshop = $this->mWorkshop->where('active', '1')->findAll();

        $provinsi = $this->mProvinsi->findAll();

        $hotel = $this->mHotel->findAll();

        array_unshift($hotel, ['id_hotel' => '0', 'nama' => 'TIDAK MENGINAP']);

        $digits = 3;
        $kodeUnik = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $D = [
            'eventSimposium' => $eventSimposium,
            'workshop' => $workshop,
            'kode_unik' => $kodeUnik,
            'provinsi' => $provinsi,
            'hotel' => $hotel,
        ];
        return view('frontend/daftar/index', $D);
    }

    public function lookupJenisKamar()
    {
        $id_hotel = $this->request->getGet('id_hotel');

        if (empty($id_hotel)) {
        }

        $jenisKamar = $this->mJenisKamarHotel->where('id_hotel', $id_hotel)->findAll();

        $optionJenisKamar = [];

        foreach ($jenisKamar as $k => $v) {
            $harga = rupiah($v['harga']);
            $optionJenisKamar[$k]['value'] = $v['id_jenis_kamar_hotel'];
            $optionJenisKamar[$k]['text'] = "$v[nama] @ $harga";
        }
        $response = [
            'option_jenis_kamar' => $optionJenisKamar,
        ];

        return $this->response->setJSON($response);
    }

    public function lookupTanggalMenginap()
    {
        $idJenisKamarHotel = $this->request->getGet('id_jenis_kamar_hotel');

        if (empty($idJenisKamarHotel)) {
        }

        $tanggalTersedia = $this->mJenisKamarHotel->getTanggalTersedia($idJenisKamarHotel);
        $optionTanggalMenginap = $this->mJenisKamarHotel->getOptionTanggalMenginap($tanggalTersedia);

        $response = [
            'option_tanggal_menginap' => $optionTanggalMenginap,

        ];
        return $this->response->setJSON($response);
    }

    public function lookupLamaMenginap()
    {
        $idJenisKamarHotel = $this->request->getGet('id_jenis_kamar_hotel');
        $tanggal = $this->request->getGet('tanggal');
        $jumlahHariBolehMenginap = $this->mJenisKamarHotel->getJumlahHariBolehMenginap($idJenisKamarHotel, $tanggal);
        $harga = $this->mJenisKamarHotel->select('harga')->where('id_jenis_kamar_hotel', $idJenisKamarHotel)->first();
        $harga = !empty($harga) ? $harga['harga'] : null;

        $optionLamaMenginap = $this->mJenisKamarHotel->getOptionLamaMenginap($tanggal, $jumlahHariBolehMenginap, $harga);

        $response = [
            'option_lama_menginap' => $optionLamaMenginap,
        ];

        return $this->response->setJSON($response);
    }
}
