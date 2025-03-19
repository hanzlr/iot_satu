<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // biasanya default MySQL user adalah 'root'
$password = ""; // password default MySQL biasanya kosong
$dbname = "iot_project"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi ke database berhasil!";

$conn->close();
?>
