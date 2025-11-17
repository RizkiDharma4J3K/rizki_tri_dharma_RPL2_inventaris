<?php
session_start();
require_once '../check_login.php';
include "../config/koneksi.php";

$id = $_GET['id'];

// Hapus kategori
mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");

echo "<script>alert('Kategori berhasil dihapus'); location='index.php';</script>";
