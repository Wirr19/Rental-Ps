<?php

$password_baru = "admin123"; 


$hash_hasil = password_hash($password_baru, PASSWORD_BCRYPT);

echo "Tulisan asli: " . $password_baru . "<br>";
echo "Kode Hash untuk di database: " . $hash_hasil;
?>