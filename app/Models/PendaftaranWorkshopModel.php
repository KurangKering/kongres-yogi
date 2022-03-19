<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class PendaftaranWorkshopModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'pendaftaran_workshop';
    protected $primaryKey           = 'id_pendaftaran_workshop';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_pendaftaran_workshop', 'id_pendaftaran', 'id_workshop'];

    // Dates
    protected $useTimestamps        = false;


    public function getByIdPendaftaran($id)
    {
        $this->where('pendaftaran_workshop.id_pendaftaran', $id);
        $this->join('workshop w', 'w.id_workshop = pendaftaran_workshop.id_workshop');
        return $this->findAll();

    }
}
