<?php
session_start();
require_once '../check_login.php';
include "../config/koneksi.php";


if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data_barang.xls");

    $cari = $_GET['cari'] ?? '';
    $kategori = $_GET['kategori'] ?? '';

    $sql = "SELECT b.*, k.nama_kategori
            FROM barang b
            JOIN kategori k ON b.id_kategori=k.id_kategori
            WHERE 1=1";

    if ($cari)     $sql .= " AND b.nama_barang LIKE '%$cari%'";
    if ($kategori) $sql .= " AND b.id_kategori='$kategori'";

    $data = mysqli_query($koneksi, $sql);

    echo "Nama Barang\tKategori\tStock\tMinimal Stok\tStatus\tHarga\tTanggal Masuk\n";
    while ($d = mysqli_fetch_assoc($data)) {
        $min = $d['min_stok'] ?: 5;
        $status = ($d['stock'] < $min) ? "Tidak Aman" : "Aman";
        echo "{$d['nama_barang']}\t{$d['nama_kategori']}\t{$d['stock']}\t$min\t$status\t{$d['harga']}\t{$d['tanggal_masuk']}\n";
    }
    exit;
}

$cari     = $_GET['cari'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$page     = $_GET['page'] ?? 1;
$per_page = 5;
$start    = ($page - 1) * $per_page;

$base_sql = "FROM barang b JOIN kategori k ON b.id_kategori=k.id_kategori WHERE 1=1";

if ($cari)     $base_sql .= " AND b.nama_barang LIKE '%$cari%'";
if ($kategori) $base_sql .= " AND b.id_kategori='$kategori'";

$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t $base_sql"))['t'];
$total_pages = ceil($total / $per_page);

$data = mysqli_query($koneksi, 
    "SELECT b.*, k.nama_kategori $base_sql LIMIT $start,$per_page"
);

$is_ajax = isset($_GET['ajax']);
if (!$is_ajax) include "../header.php";
?>

<?php if (!$is_ajax) { ?>
<h4>Data Barang</h4>

<div class="mb-2">
    <a href="tambah.php" class="btn btn-primary btn-sm">Tambah</a>
    <a href="?export=excel&cari=<?= $cari ?>&kategori=<?= $kategori ?>" class="btn btn-success btn-sm">Export Excel</a>
</div>

<form class="row mb-3" id="filter-form">
    <div class="col-md-6">
        <input type="text" id="cari" name="cari" class="form-control form-control-sm" placeholder="Cari nama barang..." value="<?= $cari ?>">
    </div>
    <div class="col-md-6">
        <select id="kategori" name="kategori" class="form-control form-control-sm">
            <option value="">Semua Kategori</option>
            <?php
            $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
            while ($k = mysqli_fetch_assoc($kat)) {
                $sel = ($kategori == $k['id_kategori']) ? 'selected' : '';
                echo "<option value='{$k['id_kategori']}' $sel>{$k['nama_kategori']}</option>";
            }
            ?>
        </select>
    </div>
</form>

<div id="data-container">
<?php } ?>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stock</th>
            <th>Min</th>
            <th>Status</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($data)) { ?>
            <?php while ($d = mysqli_fetch_assoc($data)) {
                $min = $d['min_stok'] ?: 5;
                $status = ($d['stock'] < $min) ? "Tidak Aman" : "Aman";
            ?>
            <tr>
                <td><?= $d['nama_barang'] ?></td>
                <td><?= $d['nama_kategori'] ?></td>
                <td><?= $d['stock'] ?></td>
                <td><?= $min ?></td>
                <td><?= $status ?></td>
                <td><?= $d['harga'] ?></td>
                <td><?= $d['tanggal_masuk'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $d['id_barang'] ?>" class="btn btn-light btn-sm me-1">Edit</a>
                    <a href="hapus.php?id=<?= $d['id_barang'] ?>" class="btn btn-light btn-sm"
                       onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination -->
<nav>
<ul class="pagination pagination-sm">
    <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link" href="#" data-page="<?= $page-1 ?>">«</a></li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= ($page==$i)?'active':'' ?>">
            <a class="page-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="#" data-page="<?= $page+1 ?>">»</a></li>
    <?php endif; ?>
</ul>
</nav>

<?php if (!$is_ajax) { ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cari = document.getElementById('cari');
    const kategori = document.getElementById('kategori');
    const container = document.getElementById('data-container');
    let delay = null;

    function loadData(page=1) {
        fetch(`?ajax=1&cari=${encodeURIComponent(cari.value)}&kategori=${kategori.value}&page=${page}`)
            .then(r => r.text())
            .then(html => container.innerHTML = html);
    }

    cari.addEventListener('keyup', () => {
        clearTimeout(delay);
        delay = setTimeout(() => loadData(1), 300);
    });

    kategori.addEventListener('change', () => loadData(1));

    container.addEventListener('click', e => {
        if (e.target.classList.contains('page-link')) {
            e.preventDefault(); 
            loadData(e.target.dataset.page);
        }
    });
});
</script>

<?php include "../footer.php"; } ?>
