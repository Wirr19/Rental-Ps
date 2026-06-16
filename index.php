<?php
include 'koneksi.php';
session_start();
// var_dump($_SESSION);
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// buat nampilin data di dashboard
$count_res = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM Tb_Reservasi"));
$count_cust = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM Tb_Pelanggan"));
$count_unit_ready = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM Tb_Unit_PlayStation WHERE status_unit='Tersedia'"));
$count_unit_all = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM Tb_Unit_PlayStation"));

//hitung harga
$sum_income = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total_payar) as total_masuk FROM Tb_Pembayaran"));
$total_pendapatan = $sum_income['total_masuk'] ?? 0;
?>

<?php include 'cek_login.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PS Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        .dropdown-toggle.no-arrow::after {
            display: none !important;
        }

        .dropdown-item:hover {
            background-color: #f4f4f5;
        }

        @media (max-width: 768px) {

            .table-custom {
                font-size: 12px;
            }

            .table-custom th,
            .table-custom td {
                padding: 6px 4px !important;
                white-space: nowrap;
            }

            .badge {
                font-size: 10px;
            }

        }
    </style>
</head>

<body>
    <div class="d-md-flex">
        <?php include 'sidebar.php'; ?>

        <div class="flex-grow-1">
            <?php
            $page_title = "";
            include 'topbar.php';
            ?>

            <div class="p-4">
                <div class="row g-3 mb-4 d-flex align-items-stretch">

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <small style="color: #6e6e77; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Reservasi</small>
                                <h1 class="fw-bold text-white my-2" style="font-size: 2.5rem; line-height: 1;"><?= $count_res['total']; ?></h1>
                            </div>
                            <small class="text-success" style="font-size: 0.85rem;">transaksi berjalan</small>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <small style="color: #6e6e77; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Unit Tersedia</small>
                                <h1 class="fw-bold text-white my-2" style="font-size: 2.5rem; line-height: 1;"><?= $count_unit_ready['total']; ?></h1>
                            </div>
                            <small style="color: #6e6e77; font-size: 0.85rem;">dari <?= $count_unit_all['total']; ?> unit</small>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <small style="color: #6e6e77; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pelanggan</small>
                                <h1 class="fw-bold text-white my-2" style="font-size: 2.5rem; line-height: 1;"><?= $count_cust['total']; ?></h1>
                            </div>
                            <small class="text-success" style="font-size: 0.85rem;">terdaftar</small>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <small style="color: #6e6e77; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pendapatan</small>
                                <h1 class="fw-bold text-success my-2" style="font-size: 1.9rem; line-height: 1.2; word-break: break-all;">
                                    Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?>
                                </h1>
                            </div>
                            <small class="text-success" style="font-size: 0.85rem;">kas masuk lunas</small>
                        </div>
                    </div>

                </div>

                <div class="card-custom p-4">
                    <h5 class="fw-bold text-white mb-4">Status Unit PlayStation</h5>
                    <div class="table-responsive">
                        <table class="table table-custom table-dark table-borderless m-0">
                            <thead>
                                <tr>
                                    <th>Nama Unit</th>
                                    <th>Tipe</th>
                                    <th>Harga/Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $units = mysqli_query($koneksi, "SELECT * FROM Tb_Unit_PlayStation");
                                while ($u = mysqli_fetch_assoc($units)) {
                                    $badge = 'bg-success';
                                    if ($u['status_unit'] == 'Dipakai') $badge = 'bg-danger';
                                    if ($u['status_unit'] == 'Maintenance') $badge = 'bg-warning text-dark';
                                ?>
                                    <tr>
                                        <td class="fw-bold text-white"><?= $u['nama_unit']; ?></td>
                                        <td><?= $u['tipe_playstation']; ?></td>
                                        <td><?= number_format($u['harga_sewa'] / 1000, 0); ?>K</td>
                                        <td><span class="badge <?= $badge; ?>"><?= $u['status_unit']; ?></span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>




                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>