<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\WorkshopModel;

class WorkshopController extends BaseController
{

    public function __construct()
    {
        $this->mWorkshop = new WorkshopModel();
    }
    public function index()
    {
        return view('backend/workshop/index');
    }

    public function jsonWorkshop()
    {
        echo $this->mWorkshop->jsonWorkshop();
    
    }

}
