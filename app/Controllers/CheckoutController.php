<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CheckoutModel;
use CodeIgniter\Controller;

class CheckoutController extends BaseController
{
    protected $cartModel;
    protected $checkoutModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->checkoutModel = new CheckoutModel();
    }

    public function index()
    {
        // Fetch cart items
        $cartItems = $this->cartModel->getCartItems();
        $totalPrice = 0;
    
        foreach ($cartItems as $item) {
            $totalPrice += $item['harga_jual'] * $item['quantity'];
        }
    
        // Generate invoice details
        $data = [
            'sender' => 'Sumber Jaya', // Replace with actual sender's name
            'full_name' => $this->request->getPost('full_name'),
            'receiver' => $this->request->getPost('address'), // Use the address provided in the form
            'invoice_number' => 'INV-' . time(), // Example invoice number generation
            'invoice_date' => date('Y-m-d'),
            'payment_due_date' => date('Y-m-d', strtotime('+7 days')), // Payment due in 7 days
            'items' => $cartItems,
            'totalPrice' => $totalPrice
        ];
    
        // Save the checkout data
        $this->checkoutModel->saveCheckout($data);
    
        // Load the view with the invoice details
        return view('checkout', $data);
    }
}
