<div class="container pt-5">
    <a href="<?= base_url('toko/new');?>" class="btn btn-success mb-2">Tambah Data</a>
    <div class="card">
        <div class="card-header bg-info text-white">
        <h4 class="card-title">Toko <?= session()->get('username');?></h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr> 
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $per_page = 10; // jumlah data per halaman
                    $total_data = count($getToko);
                    $total_halaman = ceil($total_data / $per_page);
                    $halaman = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
                    $start = ($halaman - 1) * $per_page;
                    $end = $start + $per_page;
                    foreach(array_slice($getToko, $start, $per_page) as $isi){?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $isi['nama_barang'];?></td>
                            <td>Rp<?= number_format($isi['harga']);?>,-</td>
                            <td>Rp<?= number_format($isi['harga_jual']);?>,-</td>
                            <td><?= $isi['stok'];?></td>
                            <td>Rp<?= number_format($isi['total']);?>,-</td>
                            <td>
                                <a href="<?= base_url('toko/edit/'.$isi['id_toko']);?>" class="btn btn-primary">Edit</a>
                                <form action="<?= base_url('toko/delete/'.$isi['id_toko']);?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                            </form>


                        </tr>
                    <?php $no++;}?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for($i = 1; $i <= $total_halaman; $i++){?>
                    <a href="?halaman=<?= $i;?>" class="btn btn-info"><?= $i;?></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>