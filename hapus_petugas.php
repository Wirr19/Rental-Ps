<?php
session_start();
include 'koneksi.php';

if(isset($_POST['hapus'])){

    $username = $_POST['username'];
    $nama_petugas = $_POST['nama_petugas'];

    $cek = mysqli_query(
        $koneksi,
        "SELECT * FROM tb_petugas
         WHERE username='$username'
         AND nama_petugas='$nama_petugas'"
    );

    if(mysqli_num_rows($cek) > 0){

        mysqli_query(
            $koneksi,
            "DELETE FROM tb_petugas
             WHERE username='$username'
             AND nama_petugas='$nama_petugas'"
        );

        echo "<script>
                alert('Petugas berhasil dihapus');
                window.location='petugas.php';
              </script>";

    } else {

        echo "<script>
                alert('Data petugas tidak ditemukan');
                window.history.back();
              </script>";
    }
}
?>
</form>