<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class PendaftaranModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'pendaftaran';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id', 'tanggal_pendaftaran', 'nama', 'tanggal_lahir', 'institusi', 'kota', 'provinsi', 'no_hp', 'email', 'id_simposium', 'status', 'kode_unik_pembayaran'];

    // Dates
    protected $useTimestamps        = false;

    public function getAll()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select id, tanggal_pendaftaran, nama, tanggal_lahir, institusi, kota, provinsi, no_hp, email, id_simposium, status, kode_unik_pembayaran from pendaftaran');

        $dt->add('action', function ($q) {
            return '';
        });

        echo $dt->generate();
    }
}
