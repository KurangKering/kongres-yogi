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
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id', 'pelatihan', 'kuota', 'waktu', 'tanggal', 'tempat', 'biaya'];

    // Dates
    protected $useTimestamps        = false;

    public function getAll()
    {
        $dt = new Datatables(new Codeigniter4Adapter());
        $dt->query('select id, pelatihan, kuota, waktu, tanggal, tempat, biaya waktu from simposium');

        $dt->add('action', function ($q) {
            return '';
        });

        $dt->edit('file', function ($q) {
            $link = base_url() . "/uploads/" . $q['file'];
            return "<a class=\"example-image-link\" href=\"" . $link . "\" data-lightbox=\"" . $link . "\"><img data-lightbox=\"image-1\"  class=\"image-dt\" src=\"" . $link . "\" alt=\"\">";
        });
        echo $dt->generate();
    }
}
