<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .table img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Your Shopping Cart</h2>
    
    <form action="<?= base_url('checkout'); ?>" method="POST">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        
        <?php if (!empty($cart_items)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Barcode</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item) { ?>
                            <tr>
                                <td><?= esc($item['nama_barang']); ?></td>
                                <td>
                                    <?php if (!empty($item['barcode'])): ?>
                                        <img src="data:image/png;base64,<?= esc($item['barcode']); ?>" alt="Barcode">
                                    <?php else: ?>
                                        No Barcode
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= esc($item['quantity']); ?></td>
                                <td class="text-end"><?= number_format($item['harga_jual'], 2); ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(<?= esc($item['id']); ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end"><?= number_format($cart_total, 2); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php } else { ?>
            <p class="text-muted">Your cart is empty.</p>
        <?php } ?>
        
        <button type="submit" class="btn btn-primary mt-3">Proceed to Checkout</button>
    </form>
</div>

<script>
function removeItem(id) {
    $.ajax({
        type: 'POST',
        url: '<?= base_url('cart/removeItem'); ?>',
        data: { id: id },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Failed to remove item. Please try again.');
            }
        },
        error: function() {
            alert('Error in the request. Please try again.');
        }
    });
}
</script>
</body>
</html>
