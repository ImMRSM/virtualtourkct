<?php
$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$user = '3pyCDrkeyay4SrZ.root';
$pass = 'f2zKclhi9yI1Bpqq';
$db   = 'test';
$port = 4000;

$conn = mysqli_init();

// WAJIB: Supaya bisa konek ke database cloud TiDB
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>
