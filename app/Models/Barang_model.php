<?php 
namespace App\Models;
use CodeIgniter\Model;

use Picqer\Barcode\BarcodeGeneratorPNG; // Import the PNG Barcode Generator

class Barang_model extends Model
{
    protected $table = 'barang';
    
    public function getBarang($id = false)
    {
        $this->select('barang.*, kategori.nama_kategori')
             ->join('kategori', 'barang.id_kategori = kategori.id_kategori');
        
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->where('id_barang', $id)->first();
        }
    }

    public function saveBarang($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function editBarang($data, $id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id_barang', $id);
        return $builder->update($data);
    }

    public function hapusBarang($id)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete(['id_barang' => $id]);
    }

    public function getKategori()
    {
        $builder = $this->db->table('kategori');
        return $builder->get()->getResultArray();
    }

    private function addBarcodeToItems($items)
{
    $generator = new BarcodeGeneratorPNG(); // Use PNG generator

    foreach ($items as &$item) {
        $barcode = $generator->getBarcode($item['id_barang'], $generator::TYPE_CODE_128);
        $item['barcode'] = 'data:image/png;base64,' . base64_encode($barcode); // Convert to base64
    }

    return $items;
}

private function addBarcodeToItem($item)
{
    if ($item) {
        $generator = new BarcodeGeneratorPNG(); // Use PNG generator
        $barcode = $generator->getBarcode($item['id_barang'], $generator::TYPE_CODE_128);
        $item['barcode'] = 'data:image/png;base64,' . base64_encode($barcode); // Convert to base64
    }

    return $item;
}
}
