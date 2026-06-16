<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_petugas
     WHERE username='$username'"
);

$petugas = mysqli_fetch_assoc($query);

if ($petugas && password_verify($password, $petugas['password'])) {

    $_SESSION['login'] = true;
    $_SESSION['id_petugas'] = $petugas['id_petugas'];
    $_SESSION['username'] = $petugas['username'];
    $_SESSION['nama_petugas'] = $petugas['nama_petugas'];
    $_SESSION['role'] = $petugas['role'];
    header("Location: index.php");
    exit();
} else {

    echo "<script>
        alert('Username atau Password salah!');
        window.location='login.php';
    </script>";
}
