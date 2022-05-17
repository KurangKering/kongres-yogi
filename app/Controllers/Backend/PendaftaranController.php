<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranJenisKamarHotelModel;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\ValidasiModel;
use App\Models\WorkshopModel;

class PendaftaranController extends BaseController
{

    public function __construct()
    {
        $this->mValidasi = new ValidasiModel();
        $this->mPendaftaran = new PendaftaranModel();
        $this->mPendaftaranWorkshop = new PendaftaranWorkshopModel();
        $this->mPendaftaranJenisKamarHotel = new PendaftaranJenisKamarHotelModel();
    }
    public function index()
    {
        return view('backend/pendaftaran/index');
    }

    public function detail($id)
    {
        $data = $this->mPendaftaran->getDetail($id);
        $workshops = $this->mPendaftaranWorkshop->getByIdPendaftaran($id);
        $penginapan = $this->mPendaftaranJenisKamarHotel->getByIdPendaftaran($id);
        $D = [
            'data' => $data,
            'workshops' => $workshops,
            'penginapan' => $penginapan,
        ];

        return view('backend/pendaftaran/detail', $D);
    }

    public function jsonPendaftaran()
    {
        $mPendaftaran = new PendaftaranModel();
        echo $mPendaftaran->jsonPendaftaran();
    }

    public function SinkronisasiTotalPembayaran()
    {
        $data_pendaftaran = $this->db->table('pendaftaran')->get()->getResultArray();
        foreach ($data_pendaftaran as $key => $value) {
            $totalPembayaranPisah = $this->mPendaftaran->getTotalPembayaran($value['id_pendaftaran'], true);

            $totalPembayaran = $totalPembayaranPisah['biaya'] + $totalPembayaranPisah['kode_unik_pembayaran'];
            $status = 1;
            if ($value['total_pembayaran'] != $totalPembayaran) {
                $status = 0;
            }
            $p = [
                'id_pendaftaran' => $value['id_pendaftaran'],
                'total_pembayaran_lama' => $value['total_pembayaran'],
                'total_pembayaran_baru' => $totalPembayaran,
                'status' => $status,
            ];

            $data = $this->db->table('log_singkronisasi_total_pembayaran')->where('id_pendaftaran', $value['id_pendaftaran'])->get()->getRowArray();
            if (empty($data)) {
                $this->db->table('log_singkronisasi_total_pembayaran')->insert($p);
            } else {
                $this->db->table('log_singkronisasi_total_pembayaran')->where('id_pendaftaran', $value['id_pendaftaran'])->update($p);
            }
            
            $this->db->table('pendaftaran')->where('id_pendaftaran', $value['id_pendaftaran'])->update(['biaya' => $totalPembayaranPisah['biaya'], 'total_pembayaran' => $totalPembayaran]);
        }

        $response =
            [
                'success' => true,
            ];
        return $this->response->setJSON($response);
    }
}
