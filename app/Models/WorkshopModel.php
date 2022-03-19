<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class WorkshopModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'workshop';
    protected $primaryKey           = 'id_workshop';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_workshop', 'id_event', 'pelatihan', 'kuota', 'waktu', 'tanggal', 'tempat', 'biaya', 'active'];

    // Dates
    protected $useTimestamps        = false;

    public function jsonWorkshop()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select e.nama_event, workshop.id_workshop, workshop.pelatihan, workshop.kuota, workshop.waktu, workshop.tempat, workshop.biaya,
        (SELECT COUNT(*) FROM pendaftaran_workshop pw WHERE pw.id_workshop = workshop.id_workshop) as terpakai
        from workshop join event e on workshop.id_event = e.id_event');

        $dt->add('action', function ($q) {
            return '';
        });
        $dt->edit('waktu', function ($q) {
            return indoDate($q['waktu'], 'd-m-Y H:i:s');
        });

        $dt->edit('biaya', function ($q) {
            return rupiah($q['biaya']);
        });



        echo $dt->generate();
    }

    public function withTerpakai($id)
    {
        $this->select("workshop.*, (SELECT COUNT(*) FROM pendaftaran_workshop pw WHERE pw.id_workshop = workshop.id_workshop) as terpakai");
        $this->where('id_workshop', $id);
        $this->where('active', '1');
        $workshop = $this->first();
        return $workshop;
        

    }


}
