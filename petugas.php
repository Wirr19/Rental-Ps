<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Cek apakah user adalah owner
$isOwner = isset($_SESSION['role']) && $_SESSION['role'] == 'owner';
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manajemen Petugas - PS Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="petugas.css">
</head>

<body>

    <div class="d-md-flex">

        <?php include 'sidebar.php'; ?>

        <main class="flex-grow-1">

            <?php
            $page_title = "Petugas";
            include 'topbar.php';
            ?>

            <div class="container-fluid p-3 p-md-4">



            </div>

            <?php if ($isOwner) { ?>

                <!-- Tambah Petugas -->
                <div class="card-custom">

                    <div class="card-title">
                        Input Petugas Baru
                    </div>

                    <form action="tambah_petugas.php" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <input type="text"
                                    name="username"
                                    class="form-control custom-input"
                                    placeholder="Username"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <input type="password"
                                    name="password"
                                    class="form-control custom-input"
                                    placeholder="Password"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <input type="text"
                                    name="nama_petugas"
                                    class="form-control custom-input"
                                    placeholder="Nama Petugas"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <input type="text"
                                    name="no_hp"
                                    class="form-control custom-input"
                                    placeholder="No HP"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <select name="role"
                                    class="form-control custom-input"
                                    required>
                                    <option value="pegawai">Pegawai</option>
                                    <option value="owner">Owner</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-end mt-4">
                            <button type="submit"
                                name="simpan"
                                class="btn btn-save">
                                Tambah Petugas
                            </button>
                        </div>

                    </form>

                </div>

                <!-- Hapus Petugas -->
                <div class="card-custom mt-4">

                    <div class="card-title">
                        Hapus Petugas
                    </div>

                    <form action="hapus_petugas.php" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <input type="text"
                                    name="username"
                                    class="form-control custom-input"
                                    placeholder="Username Petugas"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <input type="text"
                                    name="nama_petugas"
                                    class="form-control custom-input"
                                    placeholder="Nama Petugas"
                                    required>
                            </div>

                        </div>

                        <div class="text-end mt-4">
                            <button type="submit"
                                name="hapus"
                                class="btn btn-delete"
                                onclick="return confirm('Yakin ingin menghapus petugas ini?')">
                                Hapus Petugas
                            </button>
                        </div>

                    </form>

                </div>

            <?php } else { ?>
                <!-- Tampilan Pegawai -->
                <div class="card-custom">

                    <div class="card-title">
                        Akses Pegawai
                    </div>

                    <p>
                        Anda login sebagai <strong>Pegawai</strong>.
                        Anda hanya memiliki akses untuk melihat halaman ini.
                    </p>

                </div>

            <?php } ?>

            <!-- Daftar Petugas -->
            <div class="card-custom mt-4">

                <div class="card-title">
                    Daftar Petugas
                </div>

                <div class="table-responsive">

                    <table class="table petugas-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nama Petugas</th>
                                <th>No HP</th>
                                <th>Role</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $query = mysqli_query(
                                $koneksi,
                                "SELECT * FROM tb_petugas ORDER BY id_petugas ASC"
                            );

                            while ($data = mysqli_fetch_assoc($query)) {
                            ?>

                                <tr>
                                    <td><?= $data['id_petugas']; ?></td>
                                    <td><?= $data['username']; ?></td>
                                    <td><?= $data['nama_petugas']; ?></td>
                                    <td><?= $data['no_hp']; ?></td>
                                    <td>
                                        <?php if ($data['role'] == 'owner') { ?>
                                            <span class="badge bg-danger">Owner</span>
                                        <?php } else { ?>
                                            <span class="badge bg-primary">Pegawai</span>
                                        <?php } ?>
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