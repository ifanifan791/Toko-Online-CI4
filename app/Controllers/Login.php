<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    public function index()
    {
        return view('Login/vw_login', [
            'session' => session()
        ]);
    }

    public function process()
    {
        $users = new UsersModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $tabToken = $this->request->getPost('tab_token');  // Unique token for each tab

        // Validate username and password
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username' => ['required' => 'Username is required.'],
            'password' => ['required' => 'Password is required.']
        ]);

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->to(site_url('login'));
        }

        // Attempt to login
        $dataUser = $users->where('username', $username)->first();

        if ($dataUser && password_verify($password, $dataUser['password'])) {
            // Simpan data session tanpa menggunakan tabToken
            session()->set('username', $dataUser['username']);
            session()->set('nama_toko', $dataUser['nama_toko']);
            session()->set('role', $dataUser['role']);
            session()->set('id_user', $dataUser['id_user']);
            session()->set('logged_in', TRUE);
        
            // Redirect ke halaman yang sesuai dengan peran
            switch ($dataUser['role']) {
                case 'barang':
                    return redirect()->to(base_url('barang'));
                case 'toko':
                    return redirect()->to(site_url("toko/{$dataUser['id_user']}"));
                case 'home':
                    return redirect()->to(site_url("home/{$dataUser['id_user']}"));
                default:
                    session()->setFlashdata('error', 'Unknown role.');
                    return redirect()->to(site_url('login'));
            }
        } else {
            session()->setFlashdata('error', 'Invalid username or password');
            return redirect()->to(site_url('login'));
        }
    }

    public function logout()
    {
        // Hapus semua data session terkait user
        session()->remove('username');
        session()->remove('nama_toko');
        session()->remove('role');
        session()->remove('id_user');
        session()->remove('logged_in');
    
        // Hancurkan sesi jika tidak ada data yang tersisa
        if (empty(session()->get())) {
            session()->destroy();
        }
    
        return redirect()->to(site_url('login'));
    }
    
}
