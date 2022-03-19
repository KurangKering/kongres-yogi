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
    protected $primaryKey           = 'id_pendaftaran';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_pendaftaran',
        'tanggal_pendaftaran',
        'nama',
        'tanggal_lahir',
        'institusi',
        'kota',
        'provinsi',
        'no_hp',
        'email',
        'id_event_simposium',
        'status',
        'biaya',
        'kode_unik_pembayaran',
        'total_pembayaran',
        'status_email_pendaftaran'
    ];

    // Dates
    protected $useTimestamps        = false;

    public function jsonPendaftaran()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('
        select 
        pend.id_pendaftaran as id,
        pend.tanggal_pendaftaran,
        pend.nama,
        pend.tanggal_lahir,
        pend.institusi,
        pend.kota,
        pend.provinsi,
        pend.no_hp,
        pend.email,
        pend.status_email_pendaftaran,
        pend.id_event_simposium,
        pend.status,
        pend.biaya,
        pend.kode_unik_pembayaran,
        (pend.biaya + pend.kode_unik_pembayaran) as total_pembayaran,
        simposium.kategori,
        simposium.hybrid,
        es.harga,
        es.tipe_pendaftaran from pendaftaran pend
        join event_simposium es on pend.id_event_simposium = es.id_event_simposium
        join simposium on es.id_simposium = simposium.id_simposium');

        $dt->add('action', function ($q) {
            return '';
        });

        $dt->edit('tanggal_pendaftaran', function ($q) {
            return indoDate($q['tanggal_pendaftaran'], 'd-m-Y');
        });
        $dt->edit('kategori', function ($q) {
            return "$q[kategori] ($q[hybrid])";
        });
        $dt->edit('total_pembayaran', function ($q) {
            return rupiah($q['total_pembayaran']);
        });

        $dt->add('action', function ($q) {
            $buttons = "";
            $bDetail = "<button type=\"button\" bDetailPendaftaran=\"$q[id]\"><i class=\"fas fa-list\"></i> Detail</button>";
            $buttons .= $bDetail;
            return $buttons;
        });


        $dt->edit('status', function ($q) {
            return statusPendaftaran($q['status']);
        });

        echo $dt->generate();
    }

    public function isEmailUsed($id_event_simposium, $email)
    {   
        $this->where('id_event_simposium', $id_event_simposium);
        $this->where('email', $email);
        $pendaftaran = $this->first();
        return !empty($pendaftaran);
    }

    public function getDetail($id_pendaftaran)
    {
        $this->select('pendaftaran.*, v.id_validasi, v.tanggal_validasi, v.file, v.status_email_verifikasi, v.tanggal_verifikasi, es.*, s.*');
        $this->join('validasi v', 'v.id_pendaftaran =  pendaftaran.id_pendaftaran', 'LEFT');
        $this->join('event_simposium es', 'pendaftaran.id_event_simposium = es.id_event_simposium');
        $this->join('simposium s', 'es.id_simposium = s.id_simposium');
        $this->where('pendaftaran.id_pendaftaran', $id_pendaftaran);
        return $this->first();
    }
 
}
