<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class EventModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'event';
    protected $primaryKey           = 'id_event';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_event',
        'nama_event',
        'mulai_pendaftaran',
        'selesai_pendaftaran',
        'active'
    ];
    protected $useTimestamps        = false;

    public function jsonEvent()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select e.id_event, e.nama_event, e.mulai_pendaftaran, e.selesai_pendaftaran, e.active from event e');

        $dt->edit('mulai_pendaftaran', function ($q) {
            return indoDate($q['mulai_pendaftaran'], 'd-m-Y');
        });
        $dt->edit('selesai_pendaftaran', function ($q) {
            return indoDate($q['selesai_pendaftaran'], 'd-m-Y');
        });
        echo $dt->generate();
    }
}
