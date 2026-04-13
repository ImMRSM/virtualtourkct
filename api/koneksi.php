<?php
$host = 'tidbcloud.com'; // JANGAN pakai :// di depannya
$port = 4000;
$user = '2TQDRPw3eFWrkqt.root'; 
$pass = 'TIy9LEkE59zNf5OC'; 
$db   = 'test';

$conn = mysqli_init();

// Wajib pakai SSL untuk TiDB Cloud
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
