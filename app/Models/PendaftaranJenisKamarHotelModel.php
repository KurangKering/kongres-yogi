<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class PendaftaranJenisKamarHotelModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'pendaftaran_jenis_kamar_hotel';
    protected $primaryKey           = 'id_pendaftaran_jenis_kamar_hotel';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_pendaftaran_jenis_kamar_hotel',
        'id_pendaftaran',
        'id_jenis_kamar_hotel',
        'tanggal',
    ];
    protected $useTimestamps        = false;

    public function jsonPendaftaranJenisKamarHotel()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select id_pendaftaran_jenis_kamar_hotel, id_pendaftaran, id_jenis_kamar_hotel, tanggal from pendaftaran_jenis_kamar_hotel');
        echo $dt->generate();
    }
}
