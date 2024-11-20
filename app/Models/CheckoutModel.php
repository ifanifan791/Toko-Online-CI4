<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'checkout';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sender', 'receiver', 'full_name', 'invoice_number', 'invoice_date', 'payment_due_date', 'items', 'totalPrice'];

    public function saveCheckout($data)
    {
        // Serialize the items array before saving
        $data['items'] = serialize($data['items']);
        $this->insert($data);
    }

    public function getCheckout($id)
    {
        $checkout = $this->find($id);

        // Unserialize the items array after retrieving
        $checkout['items'] = unserialize($checkout['items']);

        return $checkout;
    }
}
