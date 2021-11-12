<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sentimen Analisis</title>
    <link href="vendor/dist/css/styles.css" rel="stylesheet" />
    <link href="vendor/dist/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="vendor/dist/js/all.min.js" crossorigin="anonymous"></script>

    <!-- JQUERY -->
    <script src="vendor/dist/js/jquery.js"></script> -->
    <script src="vendor/dist/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="vendor/dist/css/jquery-ui.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sentimen Analisis</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="color: azure;"></i></div>
                            Dashboard
                        </a>
                        <!-- <div class="sb-sidenav-menu-heading">Scrapping</div> -->

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file" style="color: azure;"></i></div>
                            Data Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <!-- <a class="nav-link" href="index.php?halaman=scraping">Ambil Data Twitter</a> -->
                                <a class="nav-link" href="index.php?halaman=data_latih">Data Latih</a>
                                <a class="nav-link" href="index.php?halaman=data_uji">Data Uji</a>
                                <a class="nav-link" href="index.php?halaman=hasil_filtering">Hasil Filtering</a>
                            </nav>
                        </div>

                        <!-- <a class="nav-link" href="index.php?halaman=preprocessing_pembobotan">
                            <div class="sb-nav-link-icon"><i class="fas fa-sync" style="color: azure;"></i></div>
                            Preprocessing & Pembobotan
                        </a> -->
                        <a class="nav-link" href="index.php?halaman=klasifikasi">
                            <div class="sb-nav-link-icon"><i class="fas fa-sync" style="color: azure;"></i></div>
                            Klasifikasi
                        </a>
                        <a class="nav-link" href="index.php?halaman=analisis">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar" style="color: azure;"></i></div>
                            Hasil Sentimen Analisis
                        </a>

                        <br><br><br>

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>