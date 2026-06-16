<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';


if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM Tb_Pelanggan WHERE id_pelanggan=$id");
    header("Location: pelanggan.php");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelanggan - PS Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="unit.css">
</head>

<body>

    <div class="d-md-flex">

        <?php include 'sidebar.php'; ?>

        <main class="flex-grow-1 overflow-hidden">
            <?php
            $page_title = "Pelanggan";
            include 'topbar.php'; ?>

            <div class="p-4">
                <div class="card-custom p-4">
                    <h5 class="text-white fw-bold mb-4">Daftar Member Terdaftar</h5>
                    <div class="table-responsive">
                        <table class="table table-custom table-dark table-borderless m-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Identitas</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No. WhatsApp/HP</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $data = mysqli_query($koneksi, "SELECT * FROM Tb_Pelanggan");
                                if (mysqli_num_rows($data) == 0) {
                                    echo "<tr><td colspan='6' class='text-center text-secondary py-4'>Belum ada data pelanggan.</td></tr>";
                                }
                                while ($row = mysqli_fetch_array($data)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-secondary"><?= $row['no_identitas']; ?></td>
                                        <td class="text-white fw-bold"><?= $row['nama_pelanggan']; ?></td>
                                        <td><?= $row['no_hp']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td class="text-center">
                                            <a href="pelanggan.php?hapus=<?= $row['id_pelanggan']; ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus permanen data pelanggan ini?')">
                                                🗑️ Hapus
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