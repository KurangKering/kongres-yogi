<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class HotelModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'hotel';
    protected $primaryKey           = 'id_hotel';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_hotel',
        'nama',
        'alamat',
        'bintang',
    ];
    protected $useTimestamps        = false;

    public function jsonHotel()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('
        SELECT h.id_hotel, 
        h.nama AS nama_hotel, 
        h.alamat, 
        h.bintang,
        jkh.id_jenis_kamar_hotel,
        jkh.nama AS jenis_kamar,
        jkh.jumlah,
        jkh.harga
        FROM hotel h
        JOIN jenis_kamar_hotel jkh ON h.id_hotel = jkh.id_hotel
        ');


        $dt->add('action', function ($q) {
            return '<button class="btn btn-success" bCheckTanggal="' . $q['id_jenis_kamar_hotel'] . '"><i class="far fa-calendar-check"></i> Cek Terpakai</button>';
        });

        $dt->edit('harga', function ($q) {
            return rupiah($q['harga']);
        });
        echo $dt->generate();
    }
}
