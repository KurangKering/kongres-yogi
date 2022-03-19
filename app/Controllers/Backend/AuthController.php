<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        redirect()->to('login');
    }

    public function login()
    {
        $session = session();

        if ($session->get('logged_in')) {
            return redirect()->to('/backend');
        }
        if ($this->request->isAJAX()) {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $model = new UserModel();


            $user = $model->where('username', $username)
                ->where('password', $password)
                ->first();

            if (empty($user)) {

                $response = [
                    'success' => false,
                    'message' => 'Username / Password salah',
                ];
                return $this->response->setJSON($response);
            }

            $response = [
                'success' => true,
                'redirect' => base_url('backend'),
                'message' => 'Berhasil login'
            ];

            $sess = [
                'id_user'       => $user['id_user'],
                'nama'     => $user['nama'],
                'username'     => $user['username'],
                'email'     => $user['email'],
                'logged_in'     => TRUE
            ];

            $session->set($sess);

            return $this->response->setJSON($response);
        }



        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
