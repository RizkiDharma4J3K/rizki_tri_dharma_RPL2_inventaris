<?php
session_start();
require_once '../check_login.php';
include "../config/koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id'");
echo "<script>alert('Barang berhasil dihapus'); location='index.php';</script>";
