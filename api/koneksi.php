<?php
$host = '://tidbcloud.com';
$port = 4000;
$user = '2TQDRPw3eFWrkqt.root'; // INI USER BARU
$pass = 'TIy9LEkE59zNf5OC';     // INI PASSWORD BARU
$db   = 'test';

$conn = mysqli_init();

// WAJIB: Gunakan SSL agar Vercel bisa konek ke TiDB Cloud
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
