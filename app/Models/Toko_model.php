<?php
namespace App\Models;

use CodeIgniter\Model;

class Toko_model extends Model
{
    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    protected $allowedFields = ['nama_toko', 'id_user'];

    public function getToko($id_user = false)
    {
        $this->join('barang b', 'toko.id_barang = b.id_barang')
            ->select('toko.*, b.nama_barang, b.harga');
        
        if($id_user !== false){
            $this->where('toko.id_user', $id_user);
        }
        
        return $this->findAll();
    }

    public function getBarang($id_user = false)
    {
        if($id_user !== false){
            $this->where('b.id_user', $id_user);
        }
        
        return $this->db->table('barang b')
            ->select('b.id_barang, b.nama_barang, b.harga, b.barcode')
            ->get()
            ->getResultArray();
    }
    
    public function saveToko($data)
    {
        $id_user = session()->get('id_user');
        $data['id_user'] = $id_user;
        $toko = $this->getToko($id_user);
        if (empty($toko)) {
            // if getToko returns an empty array, set nama_toko to a default value
            $data['nama_toko'] = 'Default Toko Name';
        } else {
            $data['nama_toko'] = $toko[0]['nama_toko']; // access the value as an array
        }
        $this->db->table('toko')->insert($data);
        return $this->db->affectedRows() > 0;
    }

    public function updateToko($id_toko, $data)
    {
        $this->db->table('toko')->where('id_toko', $id_toko)->update($data);
        return $this->db->affectedRows() > 0;
    }

    public function deleteToko($id)
    {
        $this->db->table('toko')->delete(['id_toko' => $id]);
        return $this->db->affectedRows() > 0;
    }

    public function getTokoByNama($nama_toko)
    {
        return $this->where('nama_toko', $nama_toko)->first();
    }
    
    public function getHargaJual($id_toko, $id_barang)
    {
        $this->select('harga_jual');
        $this->where('id_toko', $id_toko);
        $this->where('id_barang', $id_barang);
        $result = $this->find();
        return $result['harga_jual'];
    }

    public function cekStok($id_barang, $jumlah)
    {
    $stok = $this->db->table('barang')->where('id_barang', $id_barang)->get()->getRowArray();
    if ($stok['stok'] < $jumlah) {
        return false;
    } else {
        return true;
    }
}
}