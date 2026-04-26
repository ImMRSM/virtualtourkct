<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Tour Kecamatan Cimahi Tengah</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="<?= basename($_SERVER['PHP_SELF']) == 'virtualtour.php' ? 'virtualtour-page' : '' ?>">
    <!-- Header / Navbar - STICKY dengan z-index tinggi -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background: #FF5D07; z-index: 9999;">
        <div class="container">
            <!-- Logo/Brand -->
            <a class="navbar-brand fw-semibold" href="index.php">
                <i class="bi bi-building me-1"></i>
                <span>KCT</span>
            </a>

            <!-- Toggle button untuk mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background: rgba(255,255,255,0.2); padding: 8px 12px;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item mx-1">
                        <a class="nav-link px-2 py-1 rounded-2 <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active bg-white text-dark' : 'text-white' ?>"
                            href="index.php">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-2 py-1 rounded-2 <?= basename($_SERVER['PHP_SELF']) == 'virtualtour.php' ? 'active bg-white text-dark' : 'text-white' ?>"
                            href="virtualtour.php">
                            <i class="bi bi-globe-asia-australia"></i> Virtual Tour
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-2 py-1 rounded-2 <?= basename($_SERVER['PHP_SELF']) == 'pegawai.php' ? 'active bg-white text-dark' : 'text-white' ?>"
                            href="pegawai.php">
                            <i class="bi bi-person-circle me-1"></i> Pegawai
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-2 py-1 rounded-2 <?= basename($_SERVER['PHP_SELF']) == 'tentang.php' ? 'active bg-white text-dark' : 'text-white' ?>"
                            href="tentang.php">
                            <i class="bi bi-info-circle me-1"></i> Tentang
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content - tanpa pt-5 agar tidak double padding -->
    <main class="flex-fill w-100">