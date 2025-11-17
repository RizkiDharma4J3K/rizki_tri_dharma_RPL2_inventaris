<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventaris Gudang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="/inventaris/assets/custom.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/inventaris/assets/sidebar.css">
</head>
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <a href="/inventaris/" class="text-decoration-none">
                <h2 class="m-0">Inventaris</h2>
            </a>
        </div>
        <div class="list-group list-group-flush">
            <a href="/inventaris/barang/" class="list-group-item list-group-item-action">
                <i class="bi bi-box-seam me-2"></i>Barang
            </a>
            <a href="/inventaris/kategori/" class="list-group-item list-group-item-action">
                <i class="bi bi-tags me-2"></i>Kategori
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="/inventaris/logout.php" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg header-frosted">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle"><i class="bi bi-list"></i></button>
                
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <span class="navbar-text">
                                <?php echo isset($_SESSION['nama_user']) ? htmlspecialchars($_SESSION['nama_user']) : ''; ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="main-content">