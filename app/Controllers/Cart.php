<?php

namespace App\Controllers;

use App\Models\CartModel;
use CodeIgniter\Controller;

class Cart extends BaseController
{
    protected $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }

    public function index()
    {
        // Fetch all cart items
        $cart_items = $this->cartModel->getCartItems();
    
        // Initialize the cart total
        $cart_total = 0;
    
        // Calculate the total price of all items
        if ($cart_items) {
            foreach ($cart_items as $item) {
                $cart_total += $item['harga_jual'] * $item['quantity'];
            }
        } else {
            // Handle case where no items are found
            $cart_items = []; // Ensure it's an array for the view
        }
    
        // Pass data to the view
        $data = [
            'cart_items' => $cart_items,
            'cart_total' => $cart_total,
        ];
    
        return view('cart', $data);
    }
    
    
    public function addItem()
    {
        // Retrieve data from the POST request
        $id_toko = $this->request->getPost('id_toko');
        $nama_barang = $this->request->getPost('nama_barang');
        $harga_jual = $this->request->getPost('harga_jual');
        $quantity = $this->request->getPost('quantity');
        $barcode = $this->request->getPost('barcode');
        
        // Validate input data
        if (empty($id_toko) || empty($nama_barang) || empty($harga_jual) || empty($quantity) || empty($barcode)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing item data']);
        }
        
        if (!is_numeric($harga_jual) || !is_numeric($quantity)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid price or quantity']);
        }
    
        // Prepare the item data
        $itemData = [
            'id_toko' => $id_toko,
            'nama_barang' => $nama_barang,
            'harga_jual' => $harga_jual,
            'quantity' => $quantity,
            'barcode' => $barcode,
        ];
    
        // Add item to the cart
        $result = $this->cartModel->addItem($itemData);
    
        // Check if the item was added successfully
        if (!$result) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to add item to cart']);
        }
    
        // Get updated item count
        $itemCount = $this->cartModel->getItemCount();
    
        return $this->response->setJSON(['success' => true, 'itemCount' => $itemCount]);
    }       

    public function getItemCount()
    {
        $itemCount = $this->cartModel->getItemCount();
        return $this->response->setJSON(['success' => true, 'itemCount' => $itemCount]);
    }

    public function removeItem()
    {
        // Retrieve the item id from the POST request
        $id = $this->request->getPost('id');
    
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item ID is required']);
        }
    
        // Assuming you have a model method to delete an item
        $result = $this->cartModel->delete($id);
    
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to remove item']);
        }
    }    
}
