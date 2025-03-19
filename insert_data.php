<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_project";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari URL
$analog_value = $_GET['analog_value'];
$lux_value = $_GET['lux_value'];
$lamp_percentage = $_GET['lamp_status'];  // Gunakan lamp_percentage, bukan lamp_status

// Masukkan data ke database
$sql = "INSERT INTO sensor_data (analog_value, lux_value, lamp_percentage) VALUES ('$analog_value', '$lux_value', '$lamp_percentage')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan ke database!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
