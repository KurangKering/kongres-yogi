<?php

namespace App\Models;

use CodeIgniter\Model;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

/**
 * This class describes a kata dasar model.
 */
class SimposiumModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'simposium';
    protected $primaryKey           = 'id_simposium';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_simposium', 'kategori', 'hybrid'];

    // Dates
    protected $useTimestamps        = false;

    public function getAll()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select id_simposium, kategori, hybrid from simposium');

        $dt->add('action', function ($q) {
            return '';
        });

        echo $dt->generate();
    }
}
