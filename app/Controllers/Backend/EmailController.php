<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class EmailController extends BaseController
{
    public function index()
    {
        $this->db = \Config\Database::connect();
        $encrypter = \Config\Services::encrypter();

        if ($this->request->getMethod() == 'post') {
            $message = null;
            $errors = [];

            $validation =  \Config\Services::validation();
            $validation->setRules([
                'email' => [
                    'label' => 'Email', 'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'password' => [
                    'label' => 'Password', 'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'confirm_password' => [
                    'label' => 'Confirm Password', 'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'matches' => '{field} tidak sama dengan Password',
                    ],
                ],
            ]);
            if (!$validation->withRequest($this->request)->run()) {
                $errors += $validation->getErrors();
            }

            if (empty($errors)) {
                $post = [
                    'email_email' => $this->request->getPost('email'),
                    'email_password' => bin2hex($encrypter->encrypt($this->request->getPost('password'))),
                ];

                $settings = $this->db->table('settings')
                    ->where('param', 'email_email')
                    ->orWhere('param', 'email_password')
                    ->get()->getResultArray();

                $setting_email = [];
                foreach ($settings as $k => $v) {
                    $setting_email[$v['param']] = $v['value'];
                }

                foreach ($post as $k => $v) {
                    if (!isset($setting_email[$k])) {
                        $this->db->table('settings')
                            ->insert(['param' => $k, 'value' => $v]);
                    } else {
                        $this->db->table('settings')
                            ->update(['param' => $k, 'value' => $v], ['param' => $k]);
                    }
                }
                $response =
                    [
                        'success' => true,
                        'message' => 'Berhasil merubah email',
                    ];
            }

            if (empty($errors)) {
                $success = true;
                $message = "Berhasil";
                $formMessage = null;
            } else {
                $success = false;
                $message = "Gagal merubah konfigurasi email";
                $formMessage = "<div class=\"list-error\"><ul><li>" . implode("</li><li>", $errors) . "</li></ul></div>";
            }

            $response =
                [
                    'success' => $success,
                    'message' => $message,
                    'form_message' => $formMessage,
                ];

            return $this->response->setJSON($response);
        }

        $settings = $this->db->table('settings')
            ->where('param', 'email_email')
            ->orWhere('param', 'email_password')
            ->get()->getResultArray();

        $setting_email = [];
        foreach ($settings as $k => $v) {
            if ($v['param'] == 'email_password') {
                $v['value'] = $encrypter->decrypt(hex2bin($v['value']));
            }
            $setting_email[$v['param']] = $v['value'];
        }
        $D = [
            'setting_email' => $setting_email,
        ];
        return view('backend/email/index', $D);
    }
}
