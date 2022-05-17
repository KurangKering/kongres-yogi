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
        'alasan_penolakan',
    ];

    // Dates
    protected $useTimestamps        = false;

    public function jsonMenunggu()
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
        join (select max(id_validasi) id_validasi from validasi group by validasi.id_pendaftaran) maxId on validasi.id_validasi = maxId.id_validasi
        where pend.status = 'sudah_bayar'
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

    public function jsonDiterima()
    {
        $dt = new Datatables(new Codeigniter4Adapter());

        $dt->query("
        select validasi.file,
        validasi.tanggal_verifikasi,
        validasi.status_email_verifikasi,
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
        pend.kode_unik_pembayaran,
        lstp.status as status_sinkronisasi
        from validasi join pendaftaran pend on pend.id_pendaftaran = validasi.id_pendaftaran
        join (select max(id_validasi) id_validasi from validasi group by validasi.id_pendaftaran) maxId on validasi.id_validasi = maxId.id_validasi
        left join log_singkronisasi_total_pembayaran lstp on pend.id_pendaftaran = lstp.id_pendaftaran
        where pend.status = 'sukses'
        order by tanggal_verifikasi desc
        ");

        $dt->add('action', function ($q) {

            $warnaIconSend = ($q['status_email_verifikasi'] === '1') ? 'bg-green' : 'bg-yellow';
            $warnaIconSend = ($q['status_sinkronisasi'] === '0') ? 'bg-yellow' : $warnaIconSend;

            $buttons = "<div class=\"btn-group\">";
            $bDetail = "<button class=\"btn btn-sm btn-outline-info\" type=\"button\" bDetail=\"$q[id_pendaftaran]\"><i class=\"fas fa-list\"></i></button>";
            $bSendMail = "<button title=\"Kirim email\" data-tipe=\"diterima\" class=\"btn btn-sm btn-outline-info $warnaIconSend\" type=\"button\" bSendMail=\"$q[id_pendaftaran]\"><i class=\"fas fa-paper-plane\"></i></button>";

            $buttons .= $bDetail;
            $buttons .= $bSendMail;
            $buttons .= "</div>";
            return $buttons;
        });

        $dt->edit('total', function ($q) {
            return rupiah($q['total']);
        });
        $dt->edit('tanggal_verifikasi', function ($q) {
            return indoDate($q['tanggal_verifikasi'], 'd-m-Y H:i:s');
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

    public function jsonDitolak()
    {
        $dt = new Datatables(new Codeigniter4Adapter());

        $dt->query("
        select validasi.file,
        validasi.tanggal_verifikasi,
        validasi.status_email_verifikasi,
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
        join (select max(id_validasi) id_validasi from validasi group by validasi.id_pendaftaran) maxId on validasi.id_validasi = maxId.id_validasi
        where pend.status = 'gagal'
        order by tanggal_verifikasi desc
        ");

        $dt->add('action', function ($q) {
            $warnaIconSend = $q['status_email_verifikasi'] == '1' ? 'bg-green' : 'bg-yellow';
            $buttons = "<div class=\"btn-group\">";
            $bDetail = "<button class=\"btn btn-sm btn-outline-info\" type=\"button\" bDetail=\"$q[id_pendaftaran]\"><i class=\"fas fa-list\"></i> Detail</button>";
            $bSendMail = "<button title=\"Kirim email\" data-tipe=\"ditolak\" class=\"btn btn-sm btn-outline-info $warnaIconSend\" type=\"button\" bSendMail=\"$q[id_pendaftaran]\"><i class=\"fas fa-paper-plane\"></i></button>";
            $buttons .= $bDetail;
            $buttons .= $bSendMail;
            $buttons .= "</div>";
            return $buttons;
        });

        $dt->edit('total', function ($q) {
            return rupiah($q['total']);
        });
        $dt->edit('tanggal_verifikasi', function ($q) {
            return indoDate($q['tanggal_verifikasi'], 'd-m-Y H:i:s');
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

    public function jsonVerifikasi()
    {
        $dt = new Datatables(new Codeigniter4Adapter());

        $dt->query("
        select validasi.file,
        validasi.tanggal_verifikasi,
        validasi.status_email_verifikasi,
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
        where pend.status = 'sukses'
        order by tanggal_verifikasi desc
        ");

        $dt->add('action', function ($q) {
            $buttons = "<div class=\"btn-group\">";
            $bDetail = "<button class=\"btn btn-sm btn-outline-info\" type=\"button\" bDetail=\"$q[id_pendaftaran]\"><i class=\"fas fa-list\"></i> Detail</button>";
            $buttons .= $bDetail;
            $buttons .= "</div>";
            return $buttons;
        });

        $dt->edit('total', function ($q) {
            return rupiah($q['total']);
        });
        $dt->edit('tanggal_verifikasi', function ($q) {
            return indoDate($q['tanggal_verifikasi'], 'd-m-Y H:i:s');
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

    public function getDetail($id_validasi)
    {
        $this->select('pendaftaran.*, validasi.id_validasi, validasi.tanggal_validasi, validasi.file, validasi.status_email_verifikasi, validasi.tanggal_verifikasi, es.*, s.*');
        $this->join('pendaftaran', 'validasi.id_pendaftaran =  pendaftaran.id_pendaftaran');
        $this->join('event_simposium es', 'pendaftaran.id_event_simposium = es.id_event_simposium');
        $this->join('simposium s', 'es.id_simposium = s.id_simposium');
        $this->where('validasi.id_validasi', $id_validasi);
        return $this->first();
    }
}
