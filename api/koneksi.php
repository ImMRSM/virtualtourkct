<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$user = '2TQDRPw3eFWrkqt.root'; 
$pass = 'TIy9LEkE59zNf5OC'; 
$db   = 'test';

$conn = mysqli_init();

// --- BARIS INI WAJIB ADA UNTUK TiDB CLOUD ---
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
// --------------------------------------------

if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    echo "Koneksi Gagal: " . mysqli_connect_error();
    echo "<br>Error Code: " . mysqli_connect_errno();
} else {
    echo "Hore! Koneksi ke TiDB Cloud Berhasil.";
}
?>
