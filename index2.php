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
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Penjualan (Bulan)
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Penjualan (Tahun)
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>

                                </div>
                            </div>
                        </div>
                        
                    


                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Barang Masuk
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                    $ambilsemuadatatransaksi = mysqli_query($conn, "
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
                                            k.tipekategori = 'masuk' AND t.kuantitas >0
                                        
                                    ");

                                    while($data = mysqli_fetch_array($ambilsemuadatatransaksi)){
                                        $idtransaksi = $data['idtransaksi'];
                                        $namaproduk = $data['namaproduk'];
                                        $kuantitas = $data['kuantitas'];
                                        $hargasatuan = $data['hargasatuan'];
                                        $totalharga = $kuantitas * $hargasatuan;
                                        $tanggal = $data['tanggal'];
                                ?>
                                        <tr>
                                            <td><?=$idtransaksi;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$kuantitas;?></td>
                                            <td><?=$hargasatuan;?></td>
                                            <td><?=$totalharga;?></td>
                                            <td><?=$tanggal;?></td>
                                        </tr>
                                <?php
                                    };
                                ?>
                                    </tbody>
                                </table>
                                </div>

                                <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Barang Keluar
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple2" class="table table-bordered">
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
                                    $ambilsemuadatatransaksi = mysqli_query($conn, "
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
                                      k.tipekategori ='keluar' AND t.kuantitas >0
                                        
                                    ");

                                    while($data = mysqli_fetch_array($ambilsemuadatatransaksi)){
                                        $idtransaksi = $data['idtransaksi'];
                                        $namaproduk = $data['namaproduk'];
                                        $kuantitas = $data['kuantitas'];
                                        $hargasatuan = $data['hargasatuan'];
                                        $totalharga = $kuantitas * $hargasatuan;
                                        $tanggal = $data['tanggal'];
                                ?>
                                        <tr>
                                            <td><?=$idtransaksi;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$kuantitas;?></td>
                                            <td><?=$hargasatuan;?></td>
                                            <td><?=$totalharga;?></td>
                                            <td><?=$tanggal;?></td>
                                        </tr>
                                <?php
                                    };
                                ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>