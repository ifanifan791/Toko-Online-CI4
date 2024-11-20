<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home
$routes->get('home', 'Home::index');
$routes->get('home/(:num)', 'Home::index/$1');
$routes->get('item_list/(:any)', 'Home::item_list/$1');

$routes->get('/cart', 'Cart::index');  // Route to display the cart page
$routes->post('cart/addItem', 'Cart::addItem');
$routes->get('cart/getItemCount', 'Cart::getItemCount');
$routes->post('/cart/removeItem', 'Cart::removeItem');

$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout', 'CheckoutController::index');



// Home Barang
$routes->get('barang', 'Barang::index');
// Halaman Tambah Barang
$routes->get('barang/tambah', 'Barang::tambah');
// Halaman Edit Barang
$routes->get('barang/edit/(:any)', 'Barang::edit/$1');
// CRUD Barang
// Insert
$routes->post('barang/add', 'Barang::add');
// Update
$routes->post('barang/update', 'Barang::update');
// Hapus
$routes->get('barang/hapus/(:any)', 'Barang::hapus/$1');

// CRU + View Toko
$routes->presenter('toko');
$routes->post('toko/create/(:any)', 'Toko::create/$1');
$routes->delete('toko/delete/(:num)', 'Toko::delete/$1');



// Home Transaksi
$routes->get('transaksi', 'Transaksi::index');
// Halaman Tambah Barang
$routes->get('transaksi/tambah', 'Transaksi::tambah');
// Insert
$routes->post('transaksi/simpan', 'Transaksi::simpan');

// Registrasi Akun
$routes->get('/register', 'Register::index');
$routes->post('/register/process', 'Register::process');

// Login Akun
$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/logout', 'Login::logout');