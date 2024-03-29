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
    protected $primaryKey           = 'id_event_simposium';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_event_simposium',
        'id_event',
        'id_simposium',
        'tipe_pendaftaran',
        'harga',
        'mulai_pendaftaran',
        'selesai_pendaftaran',
        'active'
    ];
    protected $useTimestamps        = false;

    public function jsonEventSimposium()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select s.kategori, s.hybrid, es.id_event_simposium, es.id_simposium, tipe_pendaftaran, harga, es.mulai_pendaftaran, es.selesai_pendaftaran, es.active, e.nama_event
        from event_simposium es join simposium s on es.id_simposium = s.id_simposium
        join event e on e.id_event = es.id_event
        ');

        $dt->edit('tipe_pendaftaran', function ($q) {
            return tipePendaftaran($q['tipe_pendaftaran']);
        });

        $dt->edit('harga', function ($q) {
            return rupiah($q['harga']);
        });
        $dt->add('waktu_pendaftaran', function ($q) {

            return indoDate($q['mulai_pendaftaran'], 'd-m-Y') . ' s.d ' . indoDate($q['selesai_pendaftaran'], 'd-m-Y');
        });

        
        $dt->add('action', function ($q) {
            $buttons = "";
            $bDetail = "<button type=\"button\" bDetail=\"$q[id_event_simposium]\"><i class=\"fas fa-list\"></i> Detail</button>";
            $buttons .= $bDetail;
            return $buttons;
        });

        echo $dt->generate();
    }
}
