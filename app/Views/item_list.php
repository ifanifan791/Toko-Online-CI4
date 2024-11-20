<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Shopping Cart - Sumber Jaya</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.ico'); ?>" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container px-4 px-lg-5">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url('home'); ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
      </ul>
      <!-- Cart icon with item count -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('cart'); ?>">
            <i class="bi-cart-fill" style="font-size: 24px;"></i>
            <span class="badge badge-pill badge-danger">0</span> <!-- Default value of 0, will be updated by JavaScript -->
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <?php if (!empty($grouped_items)) { ?>
        <?php foreach ($grouped_items as $id_toko => $items) { ?>
            <?php foreach ($items as $item) { ?>
                <div class="card mb-3 w-100">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= base_url('uploads/' . $item->gambar); ?>" class="img-fluid rounded-start" alt="<?= $item->nama_barang ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item->nama_barang ?></h5>
                                <p class="card-text"><strong>Price: </strong><?= number_format($item->harga_jual, 2) ?></p>
                                <button class="btn btn-danger add-item" 
                                        data-id="<?= $item->id_toko ?>"
                                        data-name="<?= $item->nama_barang ?>"
                                        data-price="<?= $item->harga_jual ?>"
                                        data-barcode="<?= $item->barcode ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
  // Fetch initial item count for the badge
  $.ajax({
    url: '<?= base_url('cart/getItemCount'); ?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        $('.badge').text(response.itemCount);
      }
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
    }
  });

  // Handle click event on add-item button
  $('.add-item').click(function() {
    var itemId = $(this).data('id');
    var itemName = $(this).data('name');
    var itemPrice = $(this).data('price');
    var itemBarcode = $(this).data('barcode'); // Mengambil barcode dari data-barcode

    $.ajax({
    url: '<?= base_url('cart/addItem'); ?>', // URL for the request
    type: 'POST', // Method type
    data: {
        id_toko: itemId,
        nama_barang: itemName,
        harga_jual: itemPrice,
        quantity: 1,
        barcode: itemBarcode // Mengirim barcode
    },
    dataType: 'json', // Expected data type from server
    success: function(response) {
        if (response.success) {
            $('.badge').text(response.itemCount); // Update badge with item count
            alert('Item added to cart!');
        } else {
            alert('Failed to add item to cart.');
        }
    },
    error: function(xhr, status, error) {
        console.error('Error:', status, error); // Log detailed error information
        alert('An error occurred while adding the item to the cart.');
    }
});
  });
});

</script>

</body>
</html>
