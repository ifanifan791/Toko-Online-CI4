<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Toko_model;

class Toko extends Controller
{
    private $Toko_model;

    public function __construct()
    {
        $this->Toko_model = new Toko_model();
        $this->session = \Config\Services::session(); // Ensure session service is loaded
    }

    public function show($id_user)
    {
        $data['getToko'] = $this->Toko_model->join('barang', 'barang.id_barang = toko.id_barang')
            ->select('toko.*, barang.nama_barang, barang.harga')
            ->where('toko.id_user', $id_user)
            ->getToko();
        foreach ($data['getToko'] as $key => $value) {
            $data['getToko'][$key]['total'] = $value['harga_jual'] * $value['stok'];
        }
        echo view('header_view', $data);
        echo view('toko/toko_view', $data);
        echo view('footer_view', $data);
    }

    public function new()
    {
        $id_user = $this->session->get('id_user');
        $model = new Toko_model();
        $barang = $model->getBarang();
        $data = [
            'barang' => $barang,
            'id_user' => $id_user,
        ];
        return view('toko/tambah_view', $data);
    }

    public function create()
    {
        $model = new Toko_model;
        $data = array(
            'id_user' => $this->session->get('id_user'),
            'nama_toko' => $this->request->getPost('nama_toko'),
            'id_barang' => $this->request->getPost('barang_id'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok'  => $this->request->getPost('stok'),
        );

        if ($model->saveToko($data)) {
            $id_user = $this->session->get('id_user');
            return redirect()->to(base_url("toko/$id_user"));
        } else {
            echo '<script>
                    alert("Gagal Tambah Data Barang");
                    window.location="'.base_url('toko').'";
                </script>';
        }
    }

    public function edit($id)
    {
        $id_user = $this->session->get('id_user');
        $model = new Toko_model;
        $getToko = $model->find($id);
        $barang = $model->getBarang();

        $data = [
            'toko' => $getToko,
            'barang' => $barang,
            'id_user' => $id_user,
        ];

        return view('toko/edit_view', $data);
    }

    public function update($id)
    {
        $model = new Toko_model;
        $data = array(
            'nama_toko' => $this->request->getPost('nama'),
            'id_barang' => $this->request->getPost('barang_id'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok'  => $this->request->getPost('stok')
        );

        if ($model->updateToko($id, $data)) {
            $id_user = $this->session->get('id_user');
            return redirect()->to(base_url("toko/$id_user"));
        } else {
            echo '<script>
                    alert("Gagal Update Data Barang");
                    window.location="'.base_url('toko').'";
                </script>';
        }
    }

    public function delete($id)
    {
        $model = new Toko_model();
    
        if ($model->deleteToko($id)) {
            // Redirect ke halaman daftar toko setelah penghapusan
            $id_user = $this->session->get('id_user');
            return redirect()->to(base_url("toko/$id_user"));
        } else {
            // Menampilkan pesan kesalahan jika penghapusan gagal
            session()->setFlashdata('error', 'Gagal Hapus Data Toko');
            return redirect()->to(base_url('toko'));
        }
    }
    
    
}
