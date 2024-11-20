<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt of Purchase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            .invoice-area {
                display: block;
            }
            body > *:not(.invoice-area) {
                display: none;
            }
            .table-responsive {
                overflow: visible;
            }
            .table {
                width: 100%;
                margin-bottom: 0;
            }
            .table-bordered {
                border: 1px solid #ddd;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .table-light th {
                background-color: #f8f9fa;
            }
            @page {
                margin: 1cm;
            }
            .table th, .table td {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4 invoice-area">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="text-secondary">INVOICE</h4>
            </div>
            <div class="text-end">
                <p class="mb-1"><b>Sender:</b> <?= esc($sender) ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><b>Invoice:</b> <?= esc($invoice_number) ?></p>
                        <p><b>Date:</b> <?= esc($invoice_date) ?></p>
                        <p><b>Payment Due:</b> <?= esc($payment_due_date) ?></p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><b>Name:</b> <?= esc($full_name) ?></p>
                        <p><b>Receiver:</b> <?= esc($receiver) ?></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th class="text-center">Barcode</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) { ?>
                            <tr>
                                <td><?= esc($item["nama_barang"]) ?></td>
                                <td class="text-center">
                                    <img src="data:image/png;base64,<?= esc($item['barcode']) ?>" alt="Barcode" style="height: 50px;">
                                </td>
                                <td class="text-end"><?= number_format($item["harga_jual"], 2) ?></td>
                                <td class="text-end"><?= esc($item["quantity"]) ?></td>
                                <td class="text-end"><?= number_format($item["harga_jual"] * $item["quantity"], 2) ?></td>
                            </tr>
                            <?php } ?>
                            <tr class="fw-bold">
                                <td colspan="3"></td>
                                <td class="text-end">Total Harga</td>
                                <td class="text-end"><?= number_format($totalPrice, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p><u>Kindly make your payment to</u>:<br/>
                Bank: Indonesian Bank of Commerce<br/>
                A/C: 05346346543634563423<br/>
                BIC: 23141434<br/>
                </p>
                <p><i>Note: Please send a remittance advice by email to sumberjaya@commerce.com</i></p>
            </div>
        </div>
        <div class="text-end no-print mt-4">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
