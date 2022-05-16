<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class JenisKamarHotelModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'jenis_kamar_hotel';
    protected $primaryKey           = 'id_jenis_kamar_hotel';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_jenis_kamar_hotel',
        'id_hotel',
        'nama',
        'jumlah',
        'harga'
    ];
    protected $useTimestamps        = false;

    public function jsonJenisKamarHotel()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select id_jenis_kamar_hotel, id_hotel, nama, jumlah, harga from jenis_kamar_hotel');
        echo $dt->generate();
    }

    public function getTanggalTersedia($id_jenis_kamar_hotel)
    {
        $daftarTanggal = getDaftarTanggalHotel();
        $tanggalTersedia = [];
        foreach ($daftarTanggal as $k => $tanggal) {
            if ($this->checkKetersediaanKamar($id_jenis_kamar_hotel, $tanggal)) {
                $tanggalTersedia[] = $tanggal;
            }
        }

        return $tanggalTersedia;
    }

    public function checkKetersediaanKamar($idJenisKamarHotel, $tanggal)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->table('jenis_kamar_hotel jkh')
            ->select("jkh.id_jenis_kamar_hotel, h.nama as nama_hotel, h.bintang, jkh.nama as jenis_kamar, pjkh.tanggal, (jkh.jumlah) as total_kamar, COUNT(*) AS kamar_terpakai, pjkh.tanggal")
            ->join('hotel h', 'h.id_hotel = jkh.id_hotel')
            ->join('pendaftaran_jenis_kamar_hotel pjkh', 'pjkh.id_jenis_kamar_hotel = jkh.id_jenis_kamar_hotel', 'left')
            ->join('pendaftaran p', 'p.id_pendaftaran = pjkh.id_pendaftaran', 'left')
            // ->where('p.status', 'sukses')
            ->where('jkh.id_jenis_kamar_hotel', $idJenisKamarHotel)
            ->where('pjkh.tanggal', $tanggal)
            ->get()->getRowArray();

        if (empty($data)) {
            return false;
        }


        if ($data['kamar_terpakai'] >= $data['total_kamar']) {
            return false;
        }

        return true;
    }

    public function getJumlahHariBolehMenginap($id_jenis_kamar_hotel, $tanggal)
    {
        $daftarTanggalHotel = getDaftarTanggalHotel();
        $tanggalHotelAkhir = getDaftarTanggalHotel(6);
        $index = array_search($tanggal, $daftarTanggalHotel);
        $tanggalTargetMenginap = array_slice($daftarTanggalHotel, $index);

        $tanggalTersedia = [];
        foreach ($tanggalTargetMenginap as $k => $v) {
            if ($this->checkKetersediaanKamar($id_jenis_kamar_hotel, $v)) {
                $tanggalTersedia[] = $v;
            } else {
                break;
            }
        }

        return count($tanggalTersedia);
    }

    public function getOptionTanggalMenginap($tanggalMenginap)
    {
        $optionTanggalMenginap = [];
        foreach ($tanggalMenginap as $k => $v) {
            $optionTanggalMenginap[$k]['value'] = $v;
            $optionTanggalMenginap[$k]['text'] = dateFormatConverter($v);
        }

        return $optionTanggalMenginap;
    }

    public function getOptionLamaMenginap($tanggal, $jumlahHariBolehMenginap, $harga = null)
    {
        $optionLamaMenginap = [];
        for ($i = 0; $i < $jumlahHariBolehMenginap; $i++) {
            $jumlahHari = $i + 1;
            $biaya = ($harga * $jumlahHari);
            $terbilang = rupiah($biaya);
            $tanggalMenginapAkhir = date("d-m-Y", strtotime($tanggal . " + $jumlahHari days"));
            $optionLamaMenginap[$i]['value'] = $jumlahHari;
            $optionLamaMenginap[$i]['text'] = "$jumlahHari Hari (s/d $tanggalMenginapAkhir)";
            $optionLamaMenginap[$i]['harga'] = $biaya;
        }

        return $optionLamaMenginap;
    }
}
