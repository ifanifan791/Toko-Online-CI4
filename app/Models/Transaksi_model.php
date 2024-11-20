<?php 
namespace App\Models;

use CodeIgniter\Model;

class Transaksi_model extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['id_barang', 'id_toko', 'jumlah', 'total'];

    public function getTransaksi()
    {
        $this->select('t.id_transaksi, b.nama_barang, tk.nama_toko, tk.harga_jual, t.jumlah, t.total');
        $this->from($this->table . ' as t');
        $this->join('barang b', 'b.id_barang = t.id_barang');
        $this->join('toko tk', 'tk.id_toko = t.id_toko');
        $this->distinct();
        $this->orderBy('t.id_transaksi', 'DESC');
        return $this->findAll();
    }

    public function saveTransaksi($data)
    {
        // Cek stok sebelum melakukan insert
        $stokResult = $this->db->table('toko')
            ->where('id_toko', $data['id_toko'])
            ->where('id_barang', $data['id_barang'])
            ->get()->getRow();
    
        if ($stokResult === null) {
            // No results found, handle this case
            return false;
        }
    
        $stok = $stokResult->stok;
    
        if ($stok < $data['jumlah']) {
            // Jumlah melebihi stok, tidak bisa insert
            return false;
        } else {
            // Jumlah tidak melebihi stok, bisa insert
            $harga_jual = $this->db->table('toko')
                ->where('id_toko', $data['id_toko'])
                ->where('id_barang', $data['id_barang'])
                ->get()->getRow()->harga_jual;
    
            $total = $data['jumlah'] * $harga_jual;
    
            $this->db->table($this->table)
                ->insert([
                    'id_barang' => $data['id_barang'],
                    'id_toko' => $data['id_toko'],
                    'jumlah' => $data['jumlah'],
                    'total' => $total
                ]);
    
            $id_transaksi = $this->db->insertID();
    
            // Update stok
            $this->db->table('toko')
                ->where('id_toko', $data['id_toko'])
                ->where('id_barang', $data['id_barang'])
                ->set('stok', 'stok - ' . $data['jumlah'], FALSE)
                ->update();
    
            return $id_transaksi;
        }
    }

    public function getTotalBayar()
    {
        $this->select('SUM(DISTINCT t.total) as total_bayar');
        $this->from($this->table . ' as t');
        $query = $this->get();
        $result = $query->getRow();
        return $result ? $result->total_bayar : 0;
    }
}