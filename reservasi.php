<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include 'koneksi.php';


if (isset($_POST['buat_reservasi'])) {
    $no_identitas   = mysqli_real_escape_string($koneksi, $_POST['no_identitas']);
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $no_hp          = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $id_paket       = intval($_POST['id_paket']);
    $tgl_reservasi  = $_POST['tgl_reservasi'];
    $lama_sewa      = intval($_POST['lama_sewa']);
    $status_reservasi = 'Belum Bayar';

    $query_pelanggan = "INSERT INTO Tb_Pelanggan (no_identitas, nama_pelanggan, no_hp, alamat) 
                        VALUES ('$no_identitas', '$nama_pelanggan', '$no_hp', '$alamat')";

    if (mysqli_query($koneksi, $query_pelanggan)) {
        $id_pelanggan_baru = mysqli_insert_id($koneksi);

        $query_reservasi = "INSERT INTO Tb_Reservasi (id_pelanggan, id_paket, tgl_reservasi, lama_sewa, status_reservasi) 
                            VALUES ('$id_pelanggan_baru', '$id_paket', '$tgl_reservasi', '$lama_sewa', '$status_reservasi')";
        mysqli_query($koneksi, $query_reservasi);


        mysqli_query($koneksi, "UPDATE Tb_Unit_PlayStation SET status_unit='Dipakai' WHERE id_paket='$id_paket'");
    }

    echo "<script>window.location.href='reservasi.php';</script>";
    exit();
}


if (isset($_GET['konfirmasi'])) {
    $id_res = intval($_GET['konfirmasi']);


    $cek_res = mysqli_query($koneksi, "SELECT Tb_Reservasi.*, Tb_Unit_PlayStation.harga_sewa 
                                       FROM Tb_Reservasi 
                                       JOIN Tb_Unit_PlayStation ON Tb_Reservasi.id_paket = Tb_Unit_PlayStation.id_paket 
                                       WHERE id_reservasi = $id_res");
    $data_res = mysqli_fetch_assoc($cek_res);

    if ($data_res) {
        $id_paket_unit = $data_res['id_paket'];
        $total_bayar   = $data_res['lama_sewa'] * $data_res['harga_sewa'];
        $tgl_sekarang  = date('Y-m-d');


        mysqli_query($koneksi, "UPDATE Tb_Reservasi SET status_reservasi = 'Selesai' WHERE id_reservasi = $id_res");


        mysqli_query($koneksi, "UPDATE Tb_Unit_PlayStation SET status_unit = 'Tersedia' WHERE id_paket = $id_paket_unit");


        $query_bayar = "INSERT INTO Tb_Pembayaran (id_reservasi, total_payar, tgl_pembayaran, metode_pembayaran, Denda) 
                        VALUES ($id_res, $total_bayar, '$tgl_sekarang', 'Tunai', 0)";
        mysqli_query($koneksi, $query_bayar);
    }

    echo "<script>window.location.href='reservasi.php';</script>";
    exit();
}


if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    $res_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_paket FROM Tb_Reservasi WHERE id_reservasi=$id"));
    if ($res_data) {
        $id_pkt = $res_data['id_paket'];
        mysqli_query($koneksi, "UPDATE Tb_Unit_PlayStation SET status_unit='Tersedia' WHERE id_paket='$id_pkt'");
    }

    mysqli_query($koneksi, "DELETE FROM Tb_Reservasi WHERE id_reservasi=$id");
    echo "<script>window.location.href='reservasi.php';</script>";
    exit();
}
?>
<?php include 'cek_login.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reservasi - PS Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="reservasi.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <main class="content-wrapper flex-grow-1">

            <?php
            $page_title = "Reservasi";
            include 'topbar.php';
            ?>

            <div class="container-fluid p-3 p-md-4">

                <!-- FORM -->
                <div class="card-custom p-4 mb-4">
                    <h6 class="text-primary fw-bold mb-4" style="color: #6366f1 !important;">Input Reservasi Baru</h6>
                    <form action="" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-4">
                                <input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" class="form-control form-control-custom" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="no_identitas" placeholder="No. KTP/Identitas" class="form-control form-control-custom" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" name="no_hp" placeholder="No. HP" class="form-control form-control-custom" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <input type="text" name="alamat" placeholder="Alamat Lengkap Domisili" class="form-control form-control-custom" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <select name="id_paket" class="form-select form-control-custom" required>
                                    <option value="">-- Pilih Unit PS Tersedia --</option>
                                    <?php
                                    $u = mysqli_query($koneksi, "SELECT * FROM Tb_Unit_PlayStation WHERE status_unit='Tersedia'");
                                    while ($ru = mysqli_fetch_array($u)) {
                                        echo "<option value='" . $ru['id_paket'] . "'>" . $ru['nama_unit'] . " (Rp " . number_format($ru['harga_sewa'], 0, ',', '.') . "/hari)</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="date" name="tgl_reservasi" value="<?= date('Y-m-d'); ?>" class="form-control form-control-custom" required>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="number" name="lama_sewa" placeholder="Durasi Sewa (Hari)" class="form-control form-control-custom" min="1" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="buat_reservasi" class="btn btn-purple">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>


                <div class="card-custom p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-white fw-bold m-0">Daftar Transaksi</h6>

                        <a href="laporan_reservasi.php"
                            target="_blank"
                            class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom table-dark table-borderless m-0">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">PELANGGAN</th>
                                    <th style="width: 15%;">UNIT PS</th>
                                    <th style="width: 15%;">TGL KEMBALI</th>
                                    <th style="width: 15%;">TOTAL BAYAR</th>
                                    <th style="width: 15%;">STATUS</th>
                                    <th style="width: 20%;">AKSI / VERIFIKASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = "SELECT Tb_Reservasi.*, Tb_Pelanggan.nama_pelanggan, Tb_Unit_PlayStation.nama_unit, Tb_Unit_PlayStation.harga_sewa 
                                          FROM Tb_Reservasi 
                                          JOIN Tb_Pelanggan ON Tb_Reservasi.id_pelanggan = Tb_Pelanggan.id_pelanggan
                                          JOIN Tb_Unit_PlayStation ON Tb_Reservasi.id_paket = Tb_Unit_PlayStation.id_paket
                                          ORDER BY Tb_Reservasi.id_reservasi DESC";
                                $data = mysqli_query($koneksi, $q);
                                if (mysqli_num_rows($data) == 0) {
                                    echo "<tr><td colspan='6' class='text-center text-secondary py-4'>Belum ada daftar transaksi.</td></tr>";
                                }
                                while ($row = mysqli_fetch_array($data)) {
                                    $total = $row['lama_sewa'] * $row['harga_sewa'];

                                    $tgl_mulai = new DateTime($row['tgl_reservasi']);
                                    $tgl_mulai->modify('+' . $row['lama_sewa'] . ' day');
                                    $tgl_kembali = $tgl_mulai->format('Y-m-d');

                                    $is_done = ($row['status_reservasi'] == 'Selesai');
                                ?>
                                    <tr>
                                        <td class="text-white fw-bold"><?= $row['nama_pelanggan']; ?></td>
                                        <td class="text-secondary"><?= $row['nama_unit']; ?></td>
                                        <td class="text-secondary"><?= $tgl_kembali; ?></td>
                                        <td class="text-secondary">Rp <?= number_format($total, 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="<?= $is_done ? 'badge-status-selesai' : 'badge-status-belum'; ?>"> <?= $row['status_reservasi']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!$is_done) : ?>
                                                <a href="reservasi.php?konfirmasi=<?= $row['id_reservasi']; ?>"
                                                    class="text-success-custom"
                                                    onclick="return confirm('Konfirmasi pembayaran lunas untuk pesanan ini?')">
                                                    ✓ Konfirmasi
                                                </a>
                                            <?php else : ?>
                                                <span class="text-secondary small">Lunas & Masuk Kas</span>
                                            <?php endif; ?>

                                            <a href="reservasi.php?hapus=<?= $row['id_reservasi']; ?>"
                                                class="text-danger-custom"
                                                onclick="return confirm('Hapus data transaksi ini?')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>