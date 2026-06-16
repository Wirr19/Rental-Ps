<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){

    $username     = $_POST['username'];
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_petugas = $_POST['nama_petugas'];
    $no_hp        = $_POST['no_hp'];

    mysqli_query(
        $koneksi,
        "INSERT INTO tb_petugas
        (username, password, nama_petugas, no_hp)
        VALUES
        ('$username', '$password', '$nama_petugas', '$no_hp')"
    );

    header("Location: petugas.php");
    exit();
}
?>