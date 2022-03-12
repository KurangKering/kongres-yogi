<?php

namespace App\Controllers;

class ImageController extends BaseController
{
    public function buktiPembayaran($imageName)
    {
        try {
            $image = file_get_contents(WRITEPATH . 'uploads/' . $imageName);
        } catch (\Throwable $th) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $mimeType = 'image/jpg';
        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($image)
            ->send();
    }
}
