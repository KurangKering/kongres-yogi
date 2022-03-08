<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class EventSimposiumModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'event_simposium';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id', 'id_simposium', 'tipe_pendaftaran', 'harga', 'mulai_pendaftaran', 'selesai_pendaftaran', 'active'];

    // Dates
    protected $useTimestamps        = false;

    public function getAll()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select s.kategori, s.hybrid, es.id, id_simposium, tipe_pendaftaran, harga, mulai_pendaftaran, selesai_pendaftaran, active
        from event_simposium es join simposium s on es.id_simposium = s.id');

        $dt->edit('tipe_pendaftaran', function ($q) {
            return tipePendaftaran($q['tipe_pendaftaran']);
        });

        $dt->edit('harga', function ($q) {
            return rupiah($q['harga']);
        });
        $dt->add('waktu_pendaftaran', function ($q) {

            return indoDate($q['mulai_pendaftaran'], 'd-m-Y') . '-' . indoDate($q['selesai_pendaftaran'], 'd-m-Y');

        });
        
        $dt->add('action', function ($q) {
            return '';
        });

        echo $dt->generate();
    }
}
