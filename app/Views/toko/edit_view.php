<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<div class="container p-5">
<a href="<?= base_url("toko/{$id_user}");?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('toko/update/'.$toko['id_toko']);?>">
                <div class="form-group">
                    <label for="">Barang</label>
                    <select name="barang_id" required class="form-control">
                        <?php foreach ($barang as $b) : ?>
                            <option value="<?= $b['id_barang'] ?>" <?= ($toko['id_barang'] == $b['id_barang']) ? 'selected' : '' ?>><?= $b['nama_barang'] ?> - Rp<?= number_format($b['harga']);?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Harga Jual</label>
                    <input type="number" value="<?= $toko['harga_jual'];?>" name="harga_jual" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Stok</label>
                    <input type="number" value="<?= $toko['stok'];?>" name="stok" required class="form-control">
                </div>
                <input type="hidden" value="<?= $toko['id_toko'];?>" name="id_toko">
                <button class="btn btn-success">Edit Data</button>
            </form>
            
        </div>
    </div>
</div>