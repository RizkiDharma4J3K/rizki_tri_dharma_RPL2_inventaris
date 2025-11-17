<?php 
session_start();
require_once '../check_login.php';
include "../config/koneksi.php"; include "../header.php"; ?>
<h3>Tambah Kategori</h3>
<form method="post">
  <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
  <button class="btn btn-success mt-2" name="simpan">Simpan</button>
</form>
<?php
if(isset($_POST['simpan'])){
  mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES('$_POST[nama_kategori]')");
  echo "<script>alert('Kategori berhasil ditambahkan'); location='index.php';</script>";
}
include "../footer.php";
?>
    