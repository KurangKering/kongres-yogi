<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\PendaftaranWorkshopModel;
use App\Models\WorkshopModel;

class PendaftaranController extends BaseController
{
    public function index()
    {
        return view('backend/pendaftaran/index');
    }

    public function detail($id)
    {

        $mPendaftaran = new PendaftaranModel();
        $mPendaftaran->join('event_simposium', 'pendaftaran.id_event_simposium = event_simposium.id');
        $mPendaftaran->join('simposium', 'simposium.id = event_simposium.id_simposium');
        $mPendaftaran->where('pendaftaran.id', $id);
        $pendaftaran = $mPendaftaran->first();

        $mWorkshop = new PendaftaranWorkshopModel();
        $mWorkshop->join('workshop', 'workshop.id = pendaftaran_workshop.id_workshop');
        $mWorkshop->where('id_pendaftaran', $id);
        $workshops = $mWorkshop->findAll();
        
        $D = [
            'pendaftaran' => $pendaftaran,
            'workshops' => $workshops,
        ];
        return view('backend/pendaftaran/detail', $D);
    }

    public function jsonPendaftaran()
    {
        $mPendaftaran = new PendaftaranModel();
        echo $mPendaftaran->jsonPendaftaran();
    }
}
