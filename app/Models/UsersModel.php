<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
        'username',
        'password',
        'nama_toko',
        'role',
    ];

    public function joinToko()
    {
        return $this->join('toko', 'users.id_toko = toko.id_toko');
    }
}