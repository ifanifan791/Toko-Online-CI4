<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $allowedFields = ['id_toko', 'nama_barang', 'harga_jual', 'quantity', 'barcode'];

    // Function to add an item to the cart
    public function addItem($itemData)
    {
        // Fetch the barcode from the 'barang' table based on 'nama_barang'
        $db = \Config\Database::connect();
        $builder = $db->table('barang');
        $barang = $builder->select('barcode')
                          ->where('nama_barang', $itemData['nama_barang'])
                          ->get()
                          ->getRowArray();
    
        if ($barang) {
            // Add the retrieved barcode to the item data
            $itemData['barcode'] = $barang['barcode'];
        } else {
            // Handle the case where the item does not exist in the 'barang' table
            return false; // Or return a specific error message
        }
    
        // Check if the item already exists in the cart
        $existingItem = $this->where([
            'id_toko' => $itemData['id_toko'],
            'nama_barang' => $itemData['nama_barang']
        ])->first();
    
        if ($existingItem) {
            // If item exists, update the quantity
            $this->update($existingItem['id'], [
                'quantity' => $existingItem['quantity'] + $itemData['quantity']
            ]);
        } else {
            // If item doesn't exist, insert a new record
            $this->insert($itemData);
        }
        return true;
    }    

    // Function to get all cart items
    public function getCartItems()
    {
        return $this->findAll();
    }

    // Function to get the total count of items in the cart
    public function getItemCount()
    {
        return $this->countAllResults();
    }

    public function removeItem($id)
    {
        return $this->delete($id);
    }
}
