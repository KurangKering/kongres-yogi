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
        $dt->query('select id_hotel, nama, alamat, bintang from hotel');
        echo $dt->generate();
    }
}
