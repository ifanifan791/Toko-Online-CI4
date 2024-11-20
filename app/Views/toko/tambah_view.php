<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container p-5">
        <a href="<?= base_url("toko/{$id_user}");?>" class="btn btn-secondary mb-2">Kembali</a>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="card-title">Tambah Data Barang</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url("toko/create/{$id_user}");?>">
                    <div class="form-group">
                        <label for="barang_id">Barang</label>
                        <select name="barang_id" id="barang_id" class="form-control">
                            <?php foreach ($barang as $b) { ?>
                                <option value="<?= $b['id_barang']; ?>">
                                    <?= $b['nama_barang']; ?> - Rp<?= number_format($b['harga']);?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required>
                    </div>
                    <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                    <button type="submit" class="btn btn-success">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
