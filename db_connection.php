<?php
$server 	= "localhost";
$username 	= "root";
$password 	= "";
$database 	= "prediksi_c45";

$connect = new mysqli($server, $username, $password, $database);

// cek koneksi yang kita lakukan berhasil atau tidak
if ($connect->connect_error) {
	// jika terjadi error, matikan proses dengan die() atau exit();
	die('Maaf koneksi gagal: ' . $connect->connect_error);
}
