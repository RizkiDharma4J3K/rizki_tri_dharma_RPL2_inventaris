<?php 
session_start();
require_once '../check_login.php';
include "../config/koneksi.php"; 
include "../header.php"; 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$d = mysqli_fetch_assoc($data);

if (!$d) {
  echo "<script>alert('Data tidak ditemukan!'); location='index.php';</script>";
  exit;
}
?>

<h3>Edit Barang</h3>

<form method="post">

  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?= htmlspecialchars($d['nama_barang']); ?>" required>
  </div>

  <div class="mb-3">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" id="id_kategori" class="form-control" required>
      <?php
      $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
      while($k = mysqli_fetch_assoc($kat)){ ?>
        <option value="<?= $k['id_kategori']; ?>" <?= $k['id_kategori']==$d['id_kategori'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($k['nama_kategori']); ?>
        </option>
      <?php } ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" name="stock" id="stock" class="form-control" value="<?= $d['stock']; ?>" min="0" required>
  </div>

  <div class="mb-3">
    <label for="min_stok" class="form-label">Minimal Stok (Default 5)</label>
    <input type="number" name="min_stok" id="min_stok" class="form-control" value="<?= isset($d['min_stok']) ? $d['min_stok'] : 5; ?>" min="1" required>
    <small class="text-muted">Jika stok di bawah angka ini, sistem akan menandai barang sebagai <strong>stok tidak</strong>.</small>
  </div>

  <div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <input type="number" name="harga" id="harga" class="form-control" value="<?= $d['harga']; ?>" min="0" required>
  </div>

  <div class="mb-3">
    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="<?= $d['tanggal_masuk']; ?>" required>
  </div>

  <button class="btn btn-success mt-3" name="update">Update</button>
</form>

<?php
if(isset($_POST['update'])){
  $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
  $id_kategori = (int)$_POST['id_kategori'];
  $stock = (int)$_POST['stock'];
  $min_stok = (int)$_POST['min_stok'];
  if ($min_stok <= 0) $min_stok = 5;
  $harga = (int)$_POST['harga'];
  $tanggal_masuk = mysqli_real_escape_string($koneksi, $_POST['tanggal_masuk']);

  $query = "UPDATE barang SET 
              nama_barang='$nama_barang',
              id_kategori='$id_kategori',
              stock='$stock',
              min_stok='$min_stok',
              harga='$harga',
              tanggal_masuk='$tanggal_masuk'
            WHERE id_barang='$id'";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Barang berhasil diupdate'); location='index.php';</script>";
  } else {
    echo "<script>alert('Gagal mengupdate data: " . mysqli_error($koneksi) . "');</script>";
  }
}

include "../footer.php"; 
?>
