<?php 
session_start();
require_once '../check_login.php';
include "../config/koneksi.php"; 
include "../header.php"; 
?>

<h3>Tambah Barang</h3>

<form method="post">

  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" id="id_kategori" class="form-control" required>
      <option value="">Pilih Kategori</option>
      <?php 
      $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
      while($k = mysqli_fetch_assoc($kat)){ ?>
        <option value="<?= $k['id_kategori']; ?>"><?= htmlspecialchars($k['nama_kategori']); ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" name="stock" id="stock" class="form-control" min="0" required>
  </div>

  <div class="mb-3">
    <label for="min_stok" class="form-label">Minimal Stok (Default 5)</label>
    <input type="number" name="min_stok" id="min_stok" class="form-control" value="5" min="1" required>
    <small class="text-muted">Jika stok di bawah angka ini, sistem akan menandai sebagai <strong>stok tidak aman</strong>.</small>
  </div>

  <div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <input type="number" name="harga" id="harga" class="form-control" min="0" required>
  </div>

  <div class="mb-3">
    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" required>
  </div>

  <button class="btn btn-success mt-3" name="simpan">Simpan</button>
</form>

<?php
if(isset($_POST['simpan'])){
  if(empty($_POST['id_kategori'])){
    echo "<script>alert('Pilih kategori terlebih dahulu'); location='tambah.php';</script>";
    exit();
  }


  $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
  $id_kategori = (int)$_POST['id_kategori'];
  $stock = (int)$_POST['stock'];
  $min_stok = (int)$_POST['min_stok'];
  if ($min_stok <= 0) $min_stok = 5;
  $harga = (int)$_POST['harga'];
  $tanggal_masuk = mysqli_real_escape_string($koneksi, $_POST['tanggal_masuk']);

  $query = "INSERT INTO barang (nama_barang, id_kategori, stock, min_stok, harga, tanggal_masuk) VALUES(
    '$nama_barang',
    '$id_kategori',
    '$stock',
    '$min_stok',
    '$harga',
    '$tanggal_masuk'
  )";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Barang berhasil ditambahkan'); location='index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan: " . mysqli_error($koneksi) . "');</script>";
  }
}

include "../footer.php"; 
?>
