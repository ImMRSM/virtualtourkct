<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$user = '2TQDrPw3eFWrkqt.root'; // Cek huruf r-nya
$pass = 'TIy9LEkE59zNf5OC'; 
$db   = 'test';

$conn = mysqli_init();

// TiDB Cloud butuh ini untuk keamanan
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Eksekusi koneksi
$koneksi = @mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
} else {
    echo "Hore! Koneksi ke TiDB Cloud Berhasil.";
}
?>
