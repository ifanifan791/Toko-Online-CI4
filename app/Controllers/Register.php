<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\Toko_model;

class Register extends BaseController
{
    public function index()
    {
        return view('Login/vw_register');
    }

    public function process()
    {
        // Validasi input
        if (!$this->validate([
            'username' => [
                'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => 'Username sudah digunakan sebelumnya'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
            'password_conf' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan password',
                ]
            ],
            'nama_toko' => [
            ],
            'role' => [
                'rules' => 'required|in_list[toko,barang,home]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'in_list' => '{field} Harus toko',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    
        $nama_toko = $this->request->getVar('nama_toko');
        $tokoModel = new Toko_model();
    
        // Periksa apakah nama_toko sudah ada
        $existingToko = $tokoModel->getTokoByNama($nama_toko);
        if ($existingToko) {
            // Jika ada, gunakan id_toko yang ada
            $id_toko = $existingToko['id_toko'];
        } else {
            // Jika tidak ada, buat toko baru
            $tokoData = [
                'nama_toko' => $nama_toko,
                // Tambahkan field lain yang diperlukan untuk tabel toko
            ];
            $tokoModel->save($tokoData);
            $id_toko = $tokoModel->insertID();
        }
    
        // Buat pengguna baru
        $users = new UsersModel();
        $userData = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'nama_toko' => $nama_toko,
            'role' => $this->request->getVar('role'),
            'id_toko' => $id_toko,
        ];
    
        // Masukkan pengguna dan dapatkan ID pengguna
        if ($users->insert($userData)) {
            $userID = $users->insertID();
        
            // Update tabel toko dengan id_user
            $tokoModel->update($id_toko, ['id_user' => $userID]);
        
            return redirect()->to('/login');
        } else {
            // Jika insert user gagal, hapus toko yang baru dibuat
            if (isset($id_toko) && !$existingToko) {
                $tokoModel->delete($id_toko);
            }
            session()->setFlashdata('error', 'Gagal membuat pengguna.');
            return redirect()->back()->withInput();
        }  
    }
}
