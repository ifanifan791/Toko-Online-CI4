<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Transaksi_model;

class Transaksi extends Controller
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $model = new Transaksi_model(); 
        $data['getTransaksi'] = $model->getTransaksi();
        $data['totalBayar'] = $model->getTotalBayar();
        echo view('header_view', $data);
        echo view('transaksi/transaksi_view', $data);
        echo view('footer_view', $data);
    }

    public function tambah()
    {
        $barang = $this->db->table('barang')->get()->getResultArray();
        $toko = $this->db->table('toko')->get()->getResultArray();
        $data['barang'] = $barang;
        $data['toko'] = $toko;
        echo view('transaksi/tambah_view', $data);
    }

    public function simpan()
    {
        $model = new Transaksi_model();
        $id_barang = $this->request->getPost('id_barang');
        $jumlah = $this->request->getPost('jumlah');
        $id_toko = $this->request->getPost('id_toko');
    
        // Ambil stok barang di toko yang dipilih
        $toko = $this->db->table('toko')->where('id_toko', $id_toko)->get()->getRowArray();
        $stok_toko = $toko['stok'];
    
        // Cek apakah barang tersedia di toko
        if ($stok_toko < $jumlah) {
            echo '<script>
            alert("Jumlah barang melebihi stok di toko");
            window.location="'.base_url('/transaksi/tambah').'"
        </script>';
        } else {
            // Hitung total
            $harga_jual = $toko['harga_jual'];
            $total = $jumlah * $harga_jual;
    
            $data = [
                'id_barang' => $id_barang,
                'id_toko' => $id_toko,
                'jumlah' => $jumlah,
                'total' => $total,
            ];
    
            $result = $model->saveTransaksi($data);
    
            if ($result) {
                echo '<script>
                alert("Transaksi berhasil");
                window.location="'.base_url('/transaksi').'"
            </script>';
            } else {
                echo '<script>
                alert("Barang tidak tersedia");
                window.location="'.base_url('/transaksi/tambah').'"
            </script>';
            }
        }
    }
}