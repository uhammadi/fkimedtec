<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Kelompok 01</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Kelompok 01</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Side Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="produk.php">
                            <div class="sb-nav-link-icon"></div>
                            Produk
                        </a>
                        <a class="nav-link" href="supplier.php">
                            <div class="sb-nav-link-icon"></div>
                            Supplier
                        </a>
                        <a class="nav-link" href="transaksi.php">
                            <div class="sb-nav-link-icon"></div>
                            Transaksi
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Kelompok 01</li>
                    </ol>

                    <div>
                        <form method="POST" id="filterMasuk">
                            <div class="mb-3 row">
                                <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>">
                                </div>
                                <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : '' ?>">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary" name="filter_masuk">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Barang Masuk Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Barang Masuk
                            <a href="export.php" class="btn btn-info">Export Data</a>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple3" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Transaksi</th>
                                        <th>Produk</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Harga Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Initialize variables for date filter
                                    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
                                    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;

                                    // Prepare the WHERE clause for date filter
                                    $date_filter = '';
                                    if ($start_date && $end_date) {
                                        $date_filter = "AND t.tanggal BETWEEN '$start_date' AND '$end_date'";
                                    }

                                    // Fetch data with date filter
                                    $ambilsemuadatatransaksi_masuk = mysqli_query($conn, "
                                        SELECT 
                                            t.idtransaksi, 
                                            p.namaproduk, 
                                            k.tipekategori, 
                                            t.kuantitas, 
                                            p.hargasatuan, 
                                            t.tanggal
                                        FROM 
                                            transaction t
                                        JOIN 
                                            produk p ON t.idproduk = p.idproduk
                                        JOIN 
                                            kategori k ON t.idkategori = k.idkategori
                                        WHERE
                                            k.tipekategori = 'masuk' AND t.kuantitas > 0
                                            $date_filter
                                    ");

                                    $total_masuk = 0; // Initialize total harga for masuk
                                    $total_kuantitasmasuk = 0;

                                    while ($data = mysqli_fetch_array($ambilsemuadatatransaksi_masuk)) {
                                        $idtransaksi = $data['idtransaksi'];
                                        $namaproduk = $data['namaproduk'];
                                        $kuantitas = $data['kuantitas'];
                                        $total_kuantitasmasuk += $kuantitas; // Update total kuantitas masuk
                                        $hargasatuan = number_format($data['hargasatuan'], 0, ',', '.'); // Format harga satuan with commas
                                        $totalharga = $kuantitas * $data['hargasatuan'];
                                        $total_masuk += $totalharga; // Accumulate total masuk
                                        $totalharga_formatted = number_format($totalharga, 0, ',', '.'); // Format total harga with commas
                                        $tanggal = $data['tanggal'];

                                        ?>
                                        <tr>
                                            <td><?= $idtransaksi; ?></td>
                                            <td><?= $namaproduk; ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $kuantitas; ?></td>
                                            <td><?= $hargasatuan; ?></td>
                                            <td><?= $totalharga_formatted; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td><?= $total_kuantitasmasuk; ?></td>
                                        <td></td>
                                        <td><?= number_format($total_masuk, 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kelompok 01</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesSimple3').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>
</html>
