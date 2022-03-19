<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class ValidasiModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'validasi';
    protected $primaryKey           = 'id_validasi';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_validasi',
        'id_pendaftaran',
        'tanggal_validasi',
        'file',
        'status_email_verifikasi',
        'tanggal_verifikasi',
    ];

    // Dates
    protected $useTimestamps        = false;

    public function jsonValidasiSudahBayar()
    {
        $dt = new Datatables(new Codeigniter4Adapter());

        $dt->query("
        select validasi.file,
        validasi.tanggal_validasi,
        pend.id_pendaftaran,
        pend.tanggal_pendaftaran,
        pend.nama,
        pend.tanggal_lahir,
        pend.institusi,
        pend.kota,
        pend.provinsi,
        pend.no_hp,
        (pend.biaya + pend.kode_unik_pembayaran) total,
        pend.email,
        pend.status_email_pendaftaran,
        pend.id_event_simposium,
        pend.status,
        pend.kode_unik_pembayaran from validasi join pendaftaran pend on pend.id_pendaftaran = validasi.id_pendaftaran
        where pend.status = 'sudah_bayar'
        order by id_validasi asc
        ");

        $dt->add('action', function ($q) {
            $buttons = "<div class=\"btn-group\">";


            $bDetail = "<button class=\"btn btn-sm btn-outline-info\" type=\"button\" bDetail=\"$q[id_pendaftaran]\"><i class=\"fas fa-list\"></i> Detail</button>";
            $bVerifikasi = "<button class=\"btn btn-sm btn-outline-primary\" type=\"button\" bVerifikasi=\"$q[id_pendaftaran]\"><i class=\"fas fa-check\"></i> Verifikasi</button>";
            $buttons .= $bDetail;
            $buttons .= $bVerifikasi;
            $buttons .= "</div>";
            return $buttons;
        });

        $dt->edit('total', function ($q) {
            return rupiah($q['total']);
        });
        $dt->edit('tanggal_validasi', function ($q) {
            return indoDate($q['tanggal_validasi'], 'd-m-Y H:i:s');
        });
        $dt->edit('file', function ($q) {
            $link = base_url() . '/show-file/bukti-pembayaran/' . $q['file'];
            return '<a href="' . $link . '" data-fancybox data-caption="Bukti Pembayaran ' . $q['nama'] . '">
            <img class="img-pembayaran" src="' . $link . '" alt="" />
            </a>';
        });

        $dt->edit('status', function ($q) {
            $status = statusPendaftaran($q['status']);
            return is_array($status) ? null : $status;
        });

        echo $dt->generate();
    }

   
}
