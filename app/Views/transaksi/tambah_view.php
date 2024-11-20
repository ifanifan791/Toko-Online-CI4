<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<div class="container p-5">
    <a href="<?= base_url('transaksi');?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Transaksi</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('transaksi/simpan');?>" autocomplete="off">
                <div class="form-group">
                    <label for="">Nama Toko</label>
                    <select name="id_toko" class="form-control" required>
                        <option value="">Pilih Toko</option>
                        <?php foreach ($toko as $row) : ?>
                            <option value="<?= $row['id_toko']; ?>"><?= $row['nama_toko']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <select name="id_barang" class="form-control" required>
                        <option value="">Pilih Barang</option>
                        <?php foreach ($barang as $row) : ?>
                            <option value="<?= $row['id_barang']; ?>"><?= $row['nama_barang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <button class="btn btn-success">Tambah Transaksi</button>
            </form>
        </div>
    </div>
</div>