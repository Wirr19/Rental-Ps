<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';


if (isset($_POST['id_paket']) && !isset($_POST['tambah_unit'])) {

    $id_paket    = intval($_POST['id_paket']);
    $status_baru = mysqli_real_escape_string($koneksi, $_POST['status_unit']);

    $query_update = "UPDATE Tb_Unit_PlayStation SET status_unit = '$status_baru' WHERE id_paket = $id_paket";

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>window.location.href='unit.php';</script>";
        exit();
    } else {
        die("Gagal update status: " . mysqli_error($koneksi));
    }
}

//inin bagian tambah
if (isset($_POST['tambah_unit'])) {
    $nama_unit        = mysqli_real_escape_string($koneksi, $_POST['nama_unit']);
    $tipe_playstation = mysqli_real_escape_string($koneksi, $_POST['tipe_playstation']);
    $status_unit      = mysqli_real_escape_string($koneksi, $_POST['status_unit']);
    $harga_sewa       = intval($_POST['harga_sewa']);

    $query_insert = "INSERT INTO Tb_Unit_PlayStation (nama_unit, tipe_playstation, status_unit, harga_sewa) 
                     VALUES ('$nama_unit', '$tipe_playstation', '$status_unit', '$harga_sewa')";

    mysqli_query($koneksi, $query_insert);
    echo "<script>window.location.href='unit.php';</script>";
    exit();
}

// ini bagian hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM Tb_Unit_PlayStation WHERE id_paket=$id");
    echo "<script>window.location.href='unit.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Unit PS - PS Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="unit.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="d-md-flex">

        <?php include 'sidebar.php'; ?>

        <main class="flex-grow-1 overflow-hidden">
            <?php
            $page_title = "Unit PS";
            include 'topbar.php'; ?>

            <div class="container-fluid p-3 p-md-4">
                <div class="card-custom p-4 mb-4">
                    <h6 class="text-primary fw-bold mb-4" style="color: #6366f1 !important;">Tambah Unit Baru</h6>

                    <form action="" method="POST">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <input type="text" name="nama_unit" placeholder="Nama Unit (Contoh: Unit 03)" class="form-control form-control-custom" required>
                            </div>
                            <div class="col-md-3">
                                <select name="tipe_playstation" class="form-select form-control-custom" required>
                                    <option value="">-- Pilih Tipe Unit --</option>
                                    <option value="PlayStation 5">PlayStation 5</option>
                                    <option value="PlayStation 4">PlayStation 4</option>
                                    <option value="PlayStation 3">PlayStation 3</option>
                                    <option value="PlayStation 2">PlayStation 2</option>
                                    <option value="XBOX 360">XBOX 360</option>
                                    <option value="Nintendo Switch">Nintendo Switch</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="harga_sewa" placeholder="Harga Sewa / Hari (Rp)" class="form-control form-control-custom" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <select name="status_unit" class="form-select form-control-custom" required>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="tambah_unit" class="btn btn-purple">Simpan Unit</button>
                        </div>
                    </form>
                </div>

                <div class="card-custom p-4">
                    <h6 class="text-white fw-bold mb-4">Daftar Status & Pengaturan Unit</h6>
                    <div class="table-responsive">
                        <table class="table table-custom table-dark table-borderless m-0">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">NAMA UNIT</th>
                                    <th style="width: 25%;">TIPE</th>
                                    <th style="width: 20%;">HARGA / HARI</th>
                                    <th style="width: 20%;">UBAH STATUS</th>
                                    <th style="width: 10%; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = mysqli_query($koneksi, "SELECT * FROM Tb_Unit_PlayStation");
                                if (mysqli_num_rows($data) == 0) {
                                    echo "<tr><td colspan='5' class='text-center text-secondary py-4'>Belum ada unit console terdaftar.</td></tr>";
                                }
                                while ($row = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <td class="text-white fw-bold"><?= $row['nama_unit']; ?></td>
                                        <td class="text-secondary"><?= $row['tipe_playstation']; ?></td>
                                        <td class="text-secondary">Rp <?= number_format($row['harga_sewa'], 0, ',', '.'); ?></td>
                                        <td>
                                            <form action="" method="POST" class="d-flex align-items-center gap-2">
                                                <input type="hidden" name="id_paket" value="<?= $row['id_paket']; ?>">
                                                <select name="status_unit" class="form-select select-table-custom" onchange="this.form.submit()">
                                                    <option value="Tersedia" <?= ($row['status_unit'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                                    <option value="Dipakai" <?= ($row['status_unit'] == 'Dipakai') ? 'selected' : ''; ?>>Dipakai</option>
                                                    <option value="Maintenance" <?= ($row['status_unit'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                                                </select>
                                                <button type="submit" name="update_status" class="d-none"></button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <a href="unit.php?hapus=<?= $row['id_paket']; ?>"
                                                class="text-danger-custom"
                                                onclick="return confirm('Hapus unit console ini?')">
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