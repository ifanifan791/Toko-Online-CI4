<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Barang_model;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Barang extends Controller
{
    public function index()
    {
        $model = new Barang_model;
        $data['title'] = 'Data Barang';
        $data['getBarang'] = $model->getBarang();

        // No need to generate barcode here; it's already stored in the database
        echo view('header_view', $data);
        echo view('barang/barang_view', $data);
        echo view('footer_view', $data);
    }

    public function tambah()
    {
        $model = new Barang_model();
        $kategori = $model->getKategori();
        $data = [
            'kategori' => $kategori,
            'title'    => 'Tambah Data Barang'
        ];
        echo view('header_view', $data);
        echo view('barang/tambah_view', $data);
        echo view('footer_view', $data);
    }

    public function add()
    {
        $model = new Barang_model;
        $gambar = $_FILES['gambar'];
        $nama_gambar = $gambar['name'];
        $tmp_gambar = $gambar['tmp_name'];
        $error_gambar = $gambar['error'];
        $size_gambar = $gambar['size'];
    
        if ($error_gambar == 0) {
            // Move the uploaded file to a directory
            $dir = './uploads/';
            $nama_gambar_baru = uniqid() . '_' . $nama_gambar;
            move_uploaded_file($tmp_gambar, $dir . $nama_gambar_baru);
    
            // Generate the barcode
            $generator = new BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($this->request->getPost('nama'), $generator::TYPE_CODE_128));
    
            // Insert the data into the database
            $data = [
                'id_kategori' => $this->request->getPost('kategori'),
                'nama_barang' => $this->request->getPost('nama'),
                'qty'         => $this->request->getPost('qty'),
                'harga'       => $this->request->getPost('hrg'),
                'gambar'      => $nama_gambar_baru,
                'barcode'     => $barcode
            ];
            $model->saveBarang($data);
            echo '<script>
                    alert("Sukses Tambah Data Barang");
                    window.location="'.base_url('barang').'"
                </script>';
        }
    }

    public function edit($id)
    {
        $model = new Barang_model;
        $getBarang = $model->getBarang($id);
        $kategori = $model->getKategori();
        if (isset($getBarang) && is_array($getBarang) && count($getBarang) > 0) {
            $data['barang'] = $getBarang;
            $data['kategori'] = $kategori;
            $data['title'] = 'Edit ' . $getBarang['nama_barang'];
            echo view('header_view', $data);
            echo view('barang/edit_view', $data);
            echo view('footer_view', $data);
        } else {
            echo '<script>
                    alert("ID barang '.$id.' Tidak ditemukan");
                    window.location="'.base_url('barang').'"
                </script>';
        }
    }

    public function update()
    {
        $model = new Barang_model;
        $id = $this->request->getPost('id_barang');
        $gambar = $_FILES['gambar'];
        $nama_gambar = $gambar['name'];
        $tmp_gambar = $gambar['tmp_name'];
        $error_gambar = $gambar['error'];
        $size_gambar = $gambar['size'];
    
        if ($error_gambar == 0) {
            // Move the uploaded file to a directory
            $dir = './uploads/';
            $nama_gambar_baru = uniqid() . '_' . $nama_gambar;
            move_uploaded_file($tmp_gambar, $dir . $nama_gambar_baru);
    
            // Generate the barcode
            $generator = new BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($this->request->getPost('nama'), $generator::TYPE_CODE_128));
    
            // Update the data in the database
            $data = [
                'id_kategori' => $this->request->getPost('kategori'),
                'nama_barang' => $this->request->getPost('nama'),
                'qty'         => $this->request->getPost('qty'),
                'harga'       => $this->request->getPost('hrg'),
                'gambar'      => $nama_gambar_baru,
                'barcode'     => $barcode
            ];
        } else {
            // Generate the barcode
            $generator = new BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($this->request->getPost('nama'), $generator::TYPE_CODE_128));
    
            // Update the data in the database without changing the image
            $data = [
                'id_kategori' => $this->request->getPost('kategori'),
                'nama_barang' => $this->request->getPost('nama'),
                'qty'         => $this->request->getPost('qty'),
                'harga'       => $this->request->getPost('hrg'),
                'barcode'     => $barcode
            ];
        }
        $model->editBarang($data, $id);
        echo '<script>
                alert("Sukses Edit Data Barang");
                window.location="'.base_url('barang').'"
            </script>';
    }

    public function hapus($id)
    {
        $model = new Barang_model;
        $getBarang = $model->getBarang($id);
        if (isset($getBarang)) {
            $model->hapusBarang($id);
            echo '<script>
                    alert("Hapus Data Barang Sukses");
                    window.location="'.base_url('barang').'"
                </script>';
        } else {
            echo '<script>
                    alert("Hapus Gagal! ID barang '.$id.' Tidak ditemukan");
                    window.location="'.base_url('barang').'"
                </script>';
        }
    }
}
