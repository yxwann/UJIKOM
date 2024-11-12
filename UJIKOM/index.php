<?php
include "koneksi.php"; 
if (!isset($_SESSION['user'])) { //mengecek apakah sesi pengguna sudah diatur
    header('location:login.php'); //kalo sesi tida ada, arahkan ke halaman login
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Galeri Online</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Galeri Foto</a>
        <!-- Sidebar-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>


    <!-- navbar galeri foto -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Navigasi</div>
                        <a class="nav-link" href="?">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            Home
                        </a>
                        <a class="nav-link" href="?page=galeri">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            Galeri Foto
                        </a>
                        <a class="nav-link" href="?page=album">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            Album
                        </a>
                        <a class="nav-link" href="tampilan.php">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                   <!-- informasi pengguna -->
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['user']['nama_lengkap']; ?>
                </div>
            </nav>
        </div>
        <!-- akhir -->

     <!-- kunci halaman -->
        <div id="layoutSidenav_content">
            <main>

                 <?php

                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                include $page . '.php'
                ?> 

            </main>

        </div>
    </div>
    <!-- akhir -->

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>