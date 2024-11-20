<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Home extends BaseController
{
    public function index($user_id = null)
    {
        // Generate a unique token for the tab
        $tabToken = uniqid('tab_', true);

        // Load the user model
        $usersModel = new UsersModel();

        // Fetch users with role 'toko' and a valid store name
        $users = $usersModel->where('role', 'toko')
                            ->where('nama_toko IS NOT NULL')
                            ->findAll();

        // Pass the data to the view
        return view('home', [
            'users' => $users,
            'tabToken' => $tabToken,
            'user_id' => $user_id
        ]);
    }

    public function tranksaksi()
    {
        echo view('tranksaksi');
    }

    public function item_list($nama_toko)
    {
        $db = \Config\Database::connect();
        
        // Get the user ID based on the store name
        $id_user = $this->getIdUserFromNamaToko($nama_toko);
        
        if ($id_user) {
            // Query to fetch items associated with the given user ID
            $items = $db->query("
            SELECT t.id_user, t.id_toko, t.harga_jual, t.stok, b.nama_barang, b.gambar, b.barcode, u.nama_toko 
            FROM toko t 
            JOIN barang b ON t.id_barang = b.id_barang 
            JOIN users u ON t.id_user = u.id_user 
            WHERE t.id_user = ? AND u.nama_toko = ? 
            GROUP BY t.id_user, t.id_toko, b.nama_barang, t.harga_jual, t.stok, b.gambar, b.barcode
        ", [$id_user, $nama_toko])->getResult();
        
            
            // Group items by id_toko
            $grouped_items = [];
            foreach ($items as $item) {
                $grouped_items[$item->id_toko][] = $item;
            }
            
            // Prepare data for the view
            $data = [
                'grouped_items' => $grouped_items,
                'nama_toko' => $nama_toko,
            ];
            echo view('item_list', $data);
        } else {
            // Handle the case where $id_user is not found
            echo "Toko not found";
        }
    }
    
    private function getIdUserFromNamaToko($nama_toko)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('id_user');
        $builder->where('nama_toko', $nama_toko);
        $query = $builder->get();
        
        if ($query->getNumRows() > 0) {
            return $query->getRow()->id_user;
        }
        
        return null; // Return null if no user is found
    }
}