<div class="container pt-5">
    <a href="<?= base_url('barang/tambah'); ?>" class="btn btn-success mb-2">Tambah Data</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Data Barang</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Barcode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $per_page = 10;
                    $total_data = count($getBarang);
                    $total_halaman = ceil($total_data / $per_page);
                    $halaman = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
                    $start = ($halaman - 1) * $per_page;
                    $end = $start + $per_page;
                    foreach(array_slice($getBarang, $start, $per_page) as $isi){ ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $isi['nama_kategori']; ?></td>
                            <td><?= $isi['nama_barang']; ?></td>
                            <td><?= $isi['qty']; ?></td>
                            <td>Rp<?= number_format($isi['harga']); ?>,-</td>
                            <td><img src="<?= base_url('/uploads/'.$isi['gambar']); ?>" width="50" height="50"></td>
                            <td>
                            <?php if (!empty($isi['barcode'])): ?>
                                <img src="data:image/png;base64,<?= $isi['barcode']; ?>" alt="Barcode">
                            <?php else: ?>
                                No Barcode
                            <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('barang/edit/'.$isi['id_barang']); ?>" class="btn btn-success">Edit</a>
                                <a href="<?= base_url('barang/hapus/'.$isi['id_barang']); ?>" onclick="return confirm('Apakah ingin menghapus data barang?')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for($i = 1; $i <= $total_halaman; $i++) { ?>
                    <a href="?halaman=<?= $i; ?>" class="btn btn-info"><?= $i; ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
