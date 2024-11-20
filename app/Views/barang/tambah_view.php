<div class="container p-5">
    <a href="<?= base_url('barang');?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Tambah Data Barang</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('barang/add');?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Kategori</label>
                    <div>
                    <select name="kategori" id="kategori" class="form-control" required>
                    <?php foreach ($kategori as $kategori) : ?>
                        <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Qty</label>
                    <input type="number" name="qty" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" name="hrg" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>
                <button class="btn btn-success">Tambah Data</button>
            </form>
            
        </div>
    </div>
</div>