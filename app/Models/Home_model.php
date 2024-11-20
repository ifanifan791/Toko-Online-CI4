<?php
namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $table = 'home';
    protected $primaryKey = 'id';

    public function where($conditions)
    {
        $this->db->where($conditions);
        return $this;
    }
}