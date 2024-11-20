<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Halo extends Controller
{
	public function index()
	{
        $data['title']  = 'Hallo Dunia !';
        $data['msg']    = 'Selamat datang di CodeIgniter 4';
		return view('halo_view',$data);
	}

}