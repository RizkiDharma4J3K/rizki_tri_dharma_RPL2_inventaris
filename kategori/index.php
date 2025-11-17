<?php
session_start();
require_once '../check_login.php';
include "../config/koneksi.php";

// Logika untuk tabel kategori (pencarian & pagination)
$cari     = $_GET['cari'] ?? '';
$page     = $_GET['page'] ?? 1;
$per_page = 5;
$start    = ($page - 1) * $per_page;

$base_sql = "FROM kategori k LEFT JOIN barang b ON k.id_kategori = b.id_kategori WHERE 1=1";
if ($cari) {
    $base_sql .= " AND k.nama_kategori LIKE '%" . mysqli_real_escape_string($koneksi, $cari) . "%'";
}
$base_sql .= " GROUP BY k.id_kategori, k.nama_kategori";

$total_query = "SELECT COUNT(*) AS t FROM (SELECT k.id_kategori $base_sql) AS subquery";
$total = mysqli_fetch_assoc(mysqli_query($koneksi, $total_query))['t'];
$total_pages = ceil($total / $per_page);

$data_query = "SELECT k.id_kategori, k.nama_kategori, COUNT(b.id_barang) AS jumlah_barang $base_sql ORDER BY k.nama_kategori ASC LIMIT $start, $per_page";
$data = mysqli_query($koneksi, $data_query);

$is_ajax = isset($_GET['ajax']);
if (!$is_ajax) {
    include "../header.php";
}
?>

<?php if (!$is_ajax) : ?>
<div class="container mt-4">
    <h3 class="mb-4">Manajemen Kategori</h3>

    <div class="mb-2">
        <a href="tambah.php" class="btn btn-primary btn-sm">Tambah Kategori</a>
    </div>

    <form class="row mb-3" id="filter-form">
        <div class="col-md-6">
            <input type="text" id="cari" name="cari" class="form-control form-control-sm" placeholder="Cari nama kategori..." value="<?= htmlspecialchars($cari) ?>">
        </div>
    </form>

    <div id="data-container">
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
            <tr>
                <th>Nama Kategori</th>
                <th class="text-center" style="width:150px;">Jumlah Barang</th>
                <th class="text-center" style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($data) > 0) : ?>
                <?php while ($d = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td><?= htmlspecialchars($d['nama_kategori']) ?></td>
                    <td class="text-center"><?= $d['jumlah_barang'] ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $d['id_kategori'] ?>" class="btn btn-sm btn-light me-1">Edit</a>
                        <a href="hapus.php?id=<?= $d['id_kategori'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<nav>
    <ul class="pagination pagination-sm">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="#" data-page="<?= $page - 1 ?>">«</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="#" data-page="<?= $page + 1 ?>">»</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php if (!$is_ajax) : ?>
    </div> <!-- end #data-container -->

    <hr class="my-5">

    <!-- Bagian Grafik -->
    <h3 class="mb-4">Dashboard Stok Barang</h3>
    <div class="mb-4">
        <label class="form-label"><strong>Pilih Kategori untuk Melihat Detail Stok</strong></label>
        <select id="kategoriSelect" class="form-select w-50">
            <option value="">Semua Kategori</option>
            <?php
            $kategori_chart = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
            while ($k = mysqli_fetch_assoc($kategori_chart)) { ?>
                <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-8">
            <canvas id="stokChart" height="120"></canvas>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"> Status Stok</h5>
                    <ul id="stokStatusList" class="list-group small"></ul>
                    <div id="paginationContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end .container -->

<!-- ### JAVASCRIPT ### -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Script untuk Tabel Kategori (AJAX) ---
    const cariInput = document.getElementById('cari');
    const dataContainer = document.getElementById('data-container');
    let searchDelay = null;

    function loadTableData(page = 1) {
        const query = `?ajax=1&cari=${encodeURIComponent(cariInput.value)}&page=${page}`;
        fetch(query)
            .then(response => response.text())
            .then(html => {
                dataContainer.innerHTML = html;
            })
            .catch(error => console.error('Error fetching table data:', error));
    }

    cariInput.addEventListener('keyup', () => {
        clearTimeout(searchDelay);
        searchDelay = setTimeout(() => loadTableData(1), 300);
    });

    dataContainer.addEventListener('click', e => {
        if (e.target.classList.contains('page-link')) {
            e.preventDefault();
            const page = e.target.dataset.page;
            if (page) {
                loadTableData(page);
            }
        }
    });

    // --- Script untuk Grafik Stok ---
    const stokData = <?= json_encode(mysqli_fetch_all(
        mysqli_query($koneksi, "
            SELECT b.nama_barang, b.stock, b.id_kategori, k.nama_kategori
            FROM barang b
            JOIN kategori k ON b.id_kategori = k.id_kategori
        "), MYSQLI_ASSOC)); ?>;

    let chartCurrentPage = 1;
    const chartItemsPerPage = 8;
    let chartFilteredData = [];

    function updateChart(selectedKategori = '') {
        chartFilteredData = selectedKategori
            ? stokData.filter(item => item.id_kategori === selectedKategori)
            : stokData;
        
        chartCurrentPage = 1;
        renderStatusList();
        renderChart();
    }

    function renderChart() {
        const start = (chartCurrentPage - 1) * chartItemsPerPage;
        const end = start + chartItemsPerPage;
        const pageData = chartFilteredData.slice(start, end);

        const labels = pageData.map(i => i.nama_barang);
        const values = pageData.map(i => i.stock);
        const colors = values.map(v => v < 5 ? '#d9534f' : '#5cb85c');

        if (window.myChart) window.myChart.destroy();

        const ctx = document.getElementById('stokChart').getContext('2d');
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['Tidak ada data'],
                datasets: [{
                    label: 'Jumlah Stok',
                    data: values.length ? values : [0],
                    backgroundColor: colors,
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Jumlah Barang' } },
                    x: { title: { display: true, text: 'Nama Barang' } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: c => `Stok: ${c.parsed.y} (${c.parsed.y < 5 ? 'Tidak Aman' : 'Aman'})`
                        }
                    }
                },
                animation: { duration: 600, easing: 'easeOutCubic' }
            }
        });
    }

    function renderStatusList() {
        const statusList = document.getElementById('stokStatusList');
        statusList.innerHTML = '';

        if (chartFilteredData.length === 0) {
            statusList.innerHTML = '<li class="list-group-item text-center text-muted">Tidak ada data</li>';
            document.getElementById('paginationContainer').innerHTML = '';
            return;
        }

        const totalPages = Math.ceil(chartFilteredData.length / chartItemsPerPage);
        const start = (chartCurrentPage - 1) * chartItemsPerPage;
        const end = start + chartItemsPerPage;
        const pageItems = chartFilteredData.slice(start, end);

        pageItems.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `${item.nama_barang} <span class="badge ${item.stock < 5 ? 'bg-danger' : 'bg-success'}">${item.stock < 5 ? 'Tidak Aman' : 'Aman'}</span>`;
            statusList.appendChild(li);
        });

        const paginationContainer = document.getElementById('paginationContainer');
        paginationContainer.innerHTML = `
            <nav>
                <ul class="pagination justify-content-center mt-3 mb-0">
                    <li class="page-item ${chartCurrentPage === 1 ? 'disabled' : ''}">
                        <button class="page-link" onclick="changeChartPage(${chartCurrentPage - 1})">«</button>
                    </li>
                    <li class="page-item disabled"><span class="page-link">${chartCurrentPage}/${totalPages}</span></li>
                    <li class="page-item ${chartCurrentPage === totalPages ? 'disabled' : ''}">
                        <button class="page-link" onclick="changeChartPage(${chartCurrentPage + 1})">»</button>
                    </li>
                </ul>
            </nav>`;
    }

    window.changeChartPage = (page) => {
        chartCurrentPage = page;
        renderStatusList();
        renderChart();
    }

    document.getElementById('kategoriSelect').addEventListener('change', e => {
        updateChart(e.target.value);
    });

    updateChart(); // Initial chart load
});
</script>

<?php
    include "../footer.php";
?>
<?php endif; ?><?php
session_start();