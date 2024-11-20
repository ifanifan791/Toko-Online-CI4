<div class="container p-5">
    <a href="<?= base_url('barang');?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Edit Barang : <?= $barang['nama_barang'];?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('barang/update');?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <?php foreach ($kategori as $kat) : ?>
                            <option value="<?= $kat['id_kategori'] ?>" <?= ($barang['id_kategori'] == $kat['id_kategori']) ? 'selected' : '' ?>><?= $kat['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" value="<?= $barang['nama_barang'];?>" name="nama" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Qty</label>
                    <input type="number" value="<?= $barang['qty'];?>" name="qty" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" value="<?= $barang['harga'];?>" name="hrg" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    <img src="<?php echo base_url().'/uploads/'.$barang['gambar']; ?>" width="50" height="50">
                </div>
                <input type="hidden" value="<?= $barang['id_barang'];?>" name="id_barang">
                <button class="btn btn-success">Edit Data</button>
            </form>
            
        </div>
    </div>
</div>