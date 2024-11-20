<div class="container pt-5">
    <a href="<?= base_url('transaksi/tambah');?>" class="btn btn-success mb-2">Tambah Transaksi</a>
    <div id="printableArea">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Data Transaksi</h4>
        </div>
        <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Toko</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($getTransaksi as $transaksi) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $transaksi['nama_toko']; ?></td>
                            <td><?= $transaksi['nama_barang']; ?></td>
                            <td>Rp<?= number_format($transaksi['harga_jual']);?>,-</td>
                            <td><?= $transaksi['jumlah']; ?></td>
                            <td>Rp<?= number_format($transaksi['total']);?>,-</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right">Total Bayar:</td>
                            <td>Rp<?= number_format($totalBayar);?>,-</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <button onclick="printDiv('printableArea')" class="btn btn-primary">Cetak Laporan</button>
        </div>
    </div>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>