<?php 
session_start();
require_once '../check_login.php';
include "../config/koneksi.php"; 
include "../header.php"; 

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori='$id'");
$d = mysqli_fetch_assoc($data);
?>

<h3>Edit Kategori</h3>

<form method="post">
  <input type="text" name="nama_kategori" class="form-control" value="<?= $d['nama_kategori']; ?>" required>
  <button class="btn btn-success mt-2" name="update">Update</button>
</form>

<?php
if(isset($_POST['update'])){
  $nama = $_POST['nama_kategori'];
  mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori='$id'");
  echo "<script>alert('Kategori berhasil diupdate'); location='index.php';</script>";
}

include "../footer.php";
?>
