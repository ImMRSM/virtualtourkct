<?php
include 'koneksi.php';
include 'header.php';

// Ambil semua lokasi
$sql_lokasi = "SELECT * FROM lokasi ORDER BY id";
$result_lokasi = $conn->query($sql_lokasi);
$lokasi = [];
while ($row = $result_lokasi->fetch_assoc()) {
    $lokasi[$row['id']] = $row;
}

// Ambil semua hotspot
$sql_hotspot = "SELECT h.*, l.nama_lokasi as nama_tujuan FROM hotspot h JOIN lokasi l ON h.lokasi_tujuan = l.id";
$result_hotspot = $conn->query($sql_hotspot);
$hotspots = [];
while ($row = $result_hotspot->fetch_assoc()) {
    $hotspots[$row['lokasi_asal']][] = $row;
}

// Tentukan scene awal
$default_scene = isset($_GET['id']) ? (int) $_GET['id'] : 1;
if (!isset($lokasi[$default_scene])) {
    $default_scene = 1;
}

// Bangun array scenes untuk Pannellum
$scenes = [];
foreach ($lokasi as $id => $l) {
    $scene_hotspots = [];
    if (isset($hotspots[$id])) {
        foreach ($hotspots[$id] as $h) {
            $scene_hotspots[] = [
                'pitch' => $h['pitch'],
                'yaw' => $h['yaw'],
                'type' => 'scene',
                'text' => $h['nama_tujuan'],
                'sceneId' => 'scene_' . $h['lokasi_tujuan']
            ];
        }
    }
    $scenes['scene_' . $id] = [
        'hfov' => 100,
        'pitch' => 0,
        'yaw' => 0,
        'type' => 'equirectangular',
        'panorama' => $l['gambar_panorama'],
        'hotSpots' => $scene_hotspots
    ];
}

// Data untuk mini map
$map_data = [];
foreach ($lokasi as $id => $l) {
    $map_data[$id] = [
        'nama' => $l['nama_lokasi'],
        'x' => $l['map_x'],
        'y' => $l['map_y']
    ];
}

// Tentukan lantai berdasarkan ID
$current_floor = 1;
if ($default_scene >= 10 && $default_scene <= 19) {
    $current_floor = 2;
} elseif ($default_scene >= 20) {
    $current_floor = 3;
}
?>

<!-- Pannellum CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<!-- <link rel="stylesheet" href="assets/css/panellum.css"> -->
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<!-- <script src="assets/js/panellum.js"></script> -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->

<!-- Virtual Tour Custom CSS -->
<link rel="stylesheet" href="assets/css/virtualtour.css">
<link rel="stylesheet" href="assets/css/style.css">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css"> -->

<style>
    /* Reset dasar */
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        background-color: #000;
    }

    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
    }

    /* Default untuk laptop/desktop */
    #panorama-container {
        width: 100% !important;
        height: calc(100vh - 56px) !important;
        margin: 0 !important;
        padding: 0 !important;
        background-color: #000;
    }

    /* Navigasi cepat (tampilan dasar) */
    .quick-nav {
        position: relative;
        z-index: 1050;
        background: transparent;
        padding: 10px 0;
    }

    .floor-toggle {
        position: fixed;
        right: 10px;
        top: 70px;
        z-index: 1050;
    }

    .info-panel {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1040;
        max-width: 320px;
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border-left: 4px solid #FF5D07;
        pointer-events: auto;
    }

    /* ========== PERBAIKAN UNTUK HP (LAYAR ≤768px) ========== */
    @media (max-width: 768px) {
        /* Biarkan halaman bisa scroll vertikal */
        body, html {
            overflow: auto !important;
            height: auto !important;
        }

        /* Container panorama tidak fullscreen agar ada ruang scroll */
        .content-wrapper {
            margin-top: 56px;
            height: auto;
            overflow: visible;
        }

        #panorama-container {
            height: 60vh !important;   /* panorama tetap proporsional */
            width: 100% !important;
        }

        /* Panel informasi berubah mengikuti alur dokumen (tidak fixed) */
        .info-panel {
            position: relative;
            bottom: auto;
            left: auto;
            margin: 15px 10px;
            max-height: 35vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y;
        }

        .info-panel .card-body {
            overflow-y: visible;
            max-height: none;
        }

        /* Perbaikan navigasi carousel (agar tidak terlalu besar) */
        .quick-nav .floor-toggle-container {
            max-width: 280px !important;
            width: auto !important;
            min-width: 240px;
            padding: 3px !important;
        }

        .quick-nav .btn {
            min-width: 48px !important;
            padding: 3px 5px !important;
            font-size: 0.65rem !important;
        }

        .quick-nav .scroll-wrapper {
            max-width: 235px !important;
            padding: 0 18px !important;
        }

        .quick-nav .scroll-btn {
            width: 26px !important;
            height: 26px !important;
            font-size: 12px !important;
        }
    }

    /* Handphone lebih kecil (≤480px) */
    @media (max-width: 480px) {
        .quick-nav .floor-toggle-container {
            max-width: 260px !important;
            min-width: 220px;
        }
        .quick-nav .btn {
            min-width: 44px !important;
            padding: 3px 4px !important;
            font-size: 0.62rem !important;
        }
        .quick-nav .scroll-wrapper {
            max-width: 215px !important;
            padding: 0 16px !important;
        }
        .info-panel {
            max-height: 40vh;
            margin: 10px;
        }
    }

    /* Laptop/Desktop lebar (≥992px) – pastikan fullscreen lagi */
    @media (min-width: 992px) {
        body, html {
            overflow: hidden;
            height: 100%;
        }
        .content-wrapper {
            height: calc(100vh - 56px);
            overflow: hidden;
            margin-top: 56px;
        }
        #panorama-container {
            height: 100% !important;
        }
        .info-panel {
            position: fixed;
            bottom: 20px;
            left: 20px;
            max-height: 30vh;
            overflow-y: auto;
        }
        .quick-nav {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
        .floor-toggle {
            top: 80px;
        }
    }
</style>

<div class="content-wrapper" style="margin-top: 56px;">
    <!-- Panorama Container - Full screen -->
    <div id="panorama-container"></div>

    <!-- Panel Informasi Ruangan - Kiri Bawah -->
    <div class="info-panel">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden"
            style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.9); border-left: 4px solid #FF5D07;">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-1" id="ruangan-nama" style="font-size: 1rem;">
                    <?= $lokasi[$default_scene]['nama_lokasi'] ?>
                </h6>
                <p class="text-secondary small mb-0" id="ruangan-deskripsi"
                    style="font-size: 0.85rem; line-height: 1.5;">
                    <?= $lokasi[$default_scene]['deskripsi'] ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Navigasi Cepat - Atas Tengah -->
    <div class="quick-nav" style="text-align: center; margin: 0; padding: 0; background: transparent;">

        <!-- Navigasi ruangan Lantai 1 (ID 1-9) -->
        <div id="floor1-nav" class="floor-toggle-container position-relative mx-auto"
            style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px); border-radius: 60px; padding: 4px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 8px 20px rgba(0,0,0,0.4); max-width: 550px; width: fit-content; display: <?= $current_floor == 1 ? 'block' : 'none' ?>;">

            <!-- Tombol panah kiri -->
            <button class="scroll-btn scroll-left position-absolute top-50 start-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); left: -5px; font-size: 24px; font-weight: bold; transition: all 0.2s ease;">
                <i class="bi bi-caret-left-fill"></i>
            </button>

            <!-- Container scroll -->
            <div class="scroll-wrapper"
                style="overflow-x: auto; white-space: nowrap; padding: 0px 30px; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; width: 100%; max-width: 500px; margin: 0 auto;">
                <div class="d-inline-flex gap-1" style="min-width: min-content;">
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 1)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Depan
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 2)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Kasi Yanum
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 3)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Aula
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 4)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Parkiran
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 5)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Toilet 1
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 6)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Karang Taruna
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 7)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Taman
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 8)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Gudang
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 9)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        R. Rapat 2
                    </button>
                </div>
            </div>

            <!-- Tombol panah kanan -->
            <button class="scroll-btn scroll-right position-absolute top-50 end-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); right: -5px; font-size: 24px; font-weight: bold; transition: all 0.2s ease;">
                <i class="bi bi-caret-right-fill"></i>
            </button>
        </div>

        <!-- Navigasi ruangan Lantai 2 (ID 10-20) -->
        <div id="floor2-nav" class="floor-toggle-container position-relative mx-auto"
            style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px); border-radius: 60px; padding: 4px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 8px 20px rgba(0,0,0,0.4); max-width: 550px; width: fit-content; display: <?= $current_floor == 2 ? 'block' : 'none' ?>;">

            <!-- Tombol panah kiri -->
            <button class="scroll-btn scroll-left position-absolute top-50 start-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); left: -5px; font-size: 24px; font-weight: bold; transition: all 0.2s ease;">
                <i class="bi bi-caret-left-fill"></i>
            </button>

            <!-- Container scroll -->
            <div class="scroll-wrapper"
                style="overflow-x: auto; white-space: nowrap; padding: 0px 30px; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; width: 100%; max-width: 500px; margin: 0 auto;">
                <div class="d-inline-flex gap-1" style="min-width: min-content;">
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 10)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Pelayanan PKH
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 11)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Ruang Tamu
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 12)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Lorong Lantai 2
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 13)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Toilet 2
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 14)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Mushola
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 15)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Kasi Pemberdayaan
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 16)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Kasi Eksos
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 17)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Kasi Sarpras
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 18)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Kasi Pemtra
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 19)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px; transition: all 0.2s ease; font-weight: 500;">
                        Dapur
                    </button>
                </div>
            </div>

            <!-- Tombol panah kanan -->
            <button class="scroll-btn scroll-right position-absolute top-50 end-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); right: -5px; font-size: 24px; font-weight: bold; transition: all 0.2s ease;">
                <i class="bi bi-caret-right-fill"></i>
            </button>
        </div>

        <!-- Navigasi ruangan Lantai 3 (ID 20-24) -->
        <div id="floor3-nav" class="floor-toggle-container position-relative mx-auto"
            style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px); border-radius: 60px; padding: 4px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 8px 20px rgba(0,0,0,0.4); max-width: 550px; width: fit-content; display: <?= $current_floor == 3 ? 'block' : 'none' ?>;">

            <!-- Tombol panah kiri -->
            <button class="scroll-btn scroll-left position-absolute top-50 start-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); left: -5px; font-size: 24px;">
                <i class="bi bi-caret-left-fill"></i>
            </button>

            <!-- Container scroll -->
            <div class="scroll-wrapper"
                style="overflow-x: auto; white-space: nowrap; padding: 0px 30px; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; width: 100%; max-width: 500px; margin: 0 auto;">
                <div class="d-inline-flex gap-1" style="min-width: min-content;">
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 20)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px;">
                        Lorong Lantai 3
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 21)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px;">
                        Rapat 3
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 22)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px;">
                        Kasubag Umpeg
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 23)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px;">
                        Kasubag Progkeu
                    </button>
                    <button class="btn btn-sm px-3 py-2" onclick="setActiveNav(this, 24)"
                        style="min-width: 85px; font-size: 0.85rem; color: white; background: transparent; border: none; border-radius: 50px;">
                        Toilet 3
                    </button>
                </div>
            </div>

            <!-- Tombol panah kanan -->
            <button class="scroll-btn scroll-right position-absolute top-50 end-0 translate-middle-y"
                style="z-index: 20; background: #FF5D07; border: 2px solid white; border-radius: 50%; width: 36px; height: 36px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); right: -5px; font-size: 24px;">
                <i class="bi bi-caret-right-fill"></i>
            </button>
        </div>
    </div>

    <!-- Tombol pilih lantai - VERTIKAL -->
    <div class="floor-toggle position-absolute top-0 end-0 m-3" style="z-index: 1050;">
        <div class="floor-toggle-container"
            style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px); border-radius: 50px; padding: 5px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
            <div class="d-flex flex-column gap-1">
                <button class="btn btn-sm" onclick="switchFloor(1)" title="Lantai 1"
                    style="width: 40px; height: 40px; border-radius: 50%; background: <?= $current_floor == 1 ? 'white' : 'transparent' ?>; border: none; color: <?= $current_floor == 1 ? '#FF5D07' : 'white' ?>; font-weight: bold;">
                    1
                </button>
                <button class="btn btn-sm" onclick="switchFloor(2)" title="Lantai 2"
                    style="width: 40px; height: 40px; border-radius: 50%; background: <?= $current_floor == 2 ? 'white' : 'transparent' ?>; border: none; color: <?= $current_floor == 2 ? '#FF5D07' : 'white' ?>; font-weight: bold;">
                    2
                </button>
                <button class="btn btn-sm" onclick="switchFloor(3)" title="Lantai 3"
                    style="width: 40px; height: 40px; border-radius: 50%; background: <?= $current_floor == 3 ? 'white' : 'transparent' ?>; border: none; color: <?= $current_floor == 3 ? '#FF5D07' : 'white' ?>; font-weight: bold;">
                    3
                </button>
            </div>
        </div>
    </div>

    <script>
        const lokasiData = <?= json_encode($lokasi) ?>;
        const defaultScene = <?= $default_scene ?>;

        // Variabel untuk menyimpan nilai zoom saat ini
        let currentHfov = 100;
        const minZoom = 50;
        const maxZoom = 120;

        const viewer = pannellum.viewer('panorama-container', {
            "autoLoad": true,
            "autoRotate": -1,
            "default": {
                "firstScene": "scene_<?= $default_scene ?>",
                "sceneFadeDuration": 300,
                "hfov": currentHfov
            },
            "scenes": <?= json_encode($scenes) ?>
        });

        // Fungsi untuk switch antar lantai
        function switchFloor(floor) {
            const floor1Nav = document.getElementById('floor1-nav');
            const floor2Nav = document.getElementById('floor2-nav');
            const floor3Nav = document.getElementById('floor3-nav');
            const floorButtons = document.querySelectorAll('.floor-toggle .btn');

            if (!floor1Nav || !floor2Nav || !floor3Nav) return;

            if (floor === 1) {
                floor1Nav.style.display = 'block';
                floor2Nav.style.display = 'none';
                floor3Nav.style.display = 'none';
                if (floorButtons.length >= 3) {
                    floorButtons[0].style.background = 'white';
                    floorButtons[0].style.color = '#FF5D07';
                    floorButtons[1].style.background = 'transparent';
                    floorButtons[1].style.color = 'white';
                    floorButtons[2].style.background = 'transparent';
                    floorButtons[2].style.color = 'white';
                }
                if (viewer) viewer.loadScene('scene_1');
                setTimeout(() => updateCarouselButtons('floor1-nav'), 200);
            } else if (floor === 2) {
                floor1Nav.style.display = 'none';
                floor2Nav.style.display = 'block';
                floor3Nav.style.display = 'none';
                if (floorButtons.length >= 3) {
                    floorButtons[0].style.background = 'transparent';
                    floorButtons[0].style.color = 'white';
                    floorButtons[1].style.background = 'white';
                    floorButtons[1].style.color = '#FF5D07';
                    floorButtons[2].style.background = 'transparent';
                    floorButtons[2].style.color = 'white';
                }
                if (viewer) viewer.loadScene('scene_10');
                setTimeout(() => updateCarouselButtons('floor2-nav'), 200);
            } else {
                floor1Nav.style.display = 'none';
                floor2Nav.style.display = 'none';
                floor3Nav.style.display = 'block';
                if (floorButtons.length >= 3) {
                    floorButtons[0].style.background = 'transparent';
                    floorButtons[0].style.color = 'white';
                    floorButtons[1].style.background = 'transparent';
                    floorButtons[1].style.color = 'white';
                    floorButtons[2].style.background = 'white';
                    floorButtons[2].style.color = '#FF5D07';
                }
                if (viewer) viewer.loadScene('scene_20');
                setTimeout(() => updateCarouselButtons('floor3-nav'), 200);
            }
        }

        // Fungsi update tombol
        function updateCarouselButtons(containerId) {
            const navElement = document.getElementById(containerId);
            if (!navElement || navElement.style.display === 'none') return;

            const container = navElement.querySelector('.scroll-wrapper');
            const leftBtn = navElement.querySelector('.scroll-left');
            const rightBtn = navElement.querySelector('.scroll-right');

            if (!container || !leftBtn || !rightBtn) return;

            const canScrollLeft = container.scrollLeft > 5;
            const canScrollRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 5);

            leftBtn.style.display = canScrollLeft ? 'flex' : 'none';
            rightBtn.style.display = canScrollRight ? 'flex' : 'none';
        }


        // Init carousel
        function initCarousel(containerId) {
            const navElement = document.getElementById(containerId);
            if (!navElement) return;

            const container = navElement.querySelector('.scroll-wrapper');
            let leftBtn = navElement.querySelector('.scroll-left');
            let rightBtn = navElement.querySelector('.scroll-right');

            if (!container || !leftBtn || !rightBtn) return;

            // Hapus event lama (biar tidak double)
            const newLeftBtn = leftBtn.cloneNode(true);
            const newRightBtn = rightBtn.cloneNode(true);
            leftBtn.parentNode.replaceChild(newLeftBtn, leftBtn);
            rightBtn.parentNode.replaceChild(newRightBtn, rightBtn);

            leftBtn = navElement.querySelector('.scroll-left');
            rightBtn = navElement.querySelector('.scroll-right');

            // Klik kiri
            leftBtn.addEventListener('click', (e) => {
                e.preventDefault();
                container.scrollBy({
                    left: -container.clientWidth,
                    behavior: 'smooth'
                });

                setTimeout(() => updateCarouselButtons(containerId), 100);
            });

            // Klik kanan
            rightBtn.addEventListener('click', (e) => {
                e.preventDefault();
                container.scrollBy({
                    left: container.clientWidth,
                    behavior: 'smooth'
                });

                setTimeout(() => updateCarouselButtons(containerId), 100);
            });

            // Saat di-scroll manual
            container.addEventListener('scroll', () => {
                requestAnimationFrame(() => updateCarouselButtons(containerId));
            });

            // Saat resize
            window.addEventListener('resize', () => {
                updateCarouselButtons(containerId);
            });

            // update saat pertama load
            setTimeout(() => updateCarouselButtons(containerId), 200);
        }

        // Fungsi untuk set active nav
        function setActiveNav(button, sceneId) {
            if (!button) return;

            let floor = 1;
            if (sceneId >= 10 && sceneId <= 19) floor = 2;
            else if (sceneId >= 20) floor = 3;

            const currentFloorNav = floor === 1 ? 'floor1-nav' : (floor === 2 ? 'floor2-nav' : 'floor3-nav');

            const allNavButtons = document.querySelectorAll(`#${currentFloorNav} .btn`);
            allNavButtons.forEach(btn => {
                btn.classList.remove('active-nav');
                btn.style.background = 'transparent';
                btn.style.color = 'white';
            });

            button.classList.add('active-nav');
            button.style.background = 'white';
            button.style.color = '#FF5D07';

            viewer.loadScene('scene_' + sceneId);
        }

        // Event scenechange
        viewer.on('scenechange', function (sceneId) {
            const id = sceneId.replace('scene_', '');
            let floor = 1;
            if (id >= 10 && id <= 19) floor = 2;
            else if (id >= 20) floor = 3;

            const floor1Nav = document.getElementById('floor1-nav');
            const floor2Nav = document.getElementById('floor2-nav');
            const floor3Nav = document.getElementById('floor3-nav');
            const floorButtons = document.querySelectorAll('.floor-toggle .btn');

            if (floor1Nav && floor2Nav && floor3Nav) {
                if (floor === 1) {
                    floor1Nav.style.display = 'block';
                    floor2Nav.style.display = 'none';
                    floor3Nav.style.display = 'none';
                    if (floorButtons.length >= 3) {
                        floorButtons[0].style.background = 'white';
                        floorButtons[0].style.color = '#FF5D07';
                        floorButtons[1].style.background = 'transparent';
                        floorButtons[1].style.color = 'white';
                        floorButtons[2].style.background = 'transparent';
                        floorButtons[2].style.color = 'white';
                    }
                } else if (floor === 2) {
                    floor1Nav.style.display = 'none';
                    floor2Nav.style.display = 'block';
                    floor3Nav.style.display = 'none';
                    if (floorButtons.length >= 3) {
                        floorButtons[0].style.background = 'transparent';
                        floorButtons[0].style.color = 'white';
                        floorButtons[1].style.background = 'white';
                        floorButtons[1].style.color = '#FF5D07';
                        floorButtons[2].style.background = 'transparent';
                        floorButtons[2].style.color = 'white';
                    }
                } else {
                    floor1Nav.style.display = 'none';
                    floor2Nav.style.display = 'none';
                    floor3Nav.style.display = 'block';
                    if (floorButtons.length >= 3) {
                        floorButtons[0].style.background = 'transparent';
                        floorButtons[0].style.color = 'white';
                        floorButtons[1].style.background = 'transparent';
                        floorButtons[1].style.color = 'white';
                        floorButtons[2].style.background = 'white';
                        floorButtons[2].style.color = '#FF5D07';
                    }
                }
            }

            const currentFloorNav = floor === 1 ? 'floor1-nav' : (floor === 2 ? 'floor2-nav' : 'floor3-nav');
            const buttons = document.querySelectorAll(`#${currentFloorNav} .btn`);

            buttons.forEach((btn, index) => {
                let expectedId = index + 1;
                if (floor === 2) expectedId = index + 10;
                if (floor === 3) expectedId = index + 20;

                if (expectedId == id) {
                    btn.classList.add('active-nav');
                    btn.style.background = 'white';
                    btn.style.color = '#FF5D07';
                } else {
                    btn.classList.remove('active-nav');
                    btn.style.background = 'transparent';
                    btn.style.color = 'white';
                }
            });

            // Update informasi ruangan
            const namaEl = document.getElementById('ruangan-nama');
            const descEl = document.getElementById('ruangan-deskripsi');

            if (namaEl && descEl && lokasiData) {
                namaEl.style.opacity = '0';
                descEl.style.opacity = '0';

                setTimeout(() => {
                    namaEl.innerText = lokasiData[id]?.nama_lokasi || 'Ruangan';
                    descEl.innerText = lokasiData[id]?.deskripsi || 'Deskripsi tidak tersedia';
                    namaEl.style.opacity = '1';
                    descEl.style.opacity = '1';
                }, 200);
            }
        });

        window.addEventListener('resize', function () {
            const container = document.getElementById('panorama-container');
            if (container) container.style.height = window.innerHeight + 'px';
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Set display lantai dan active button
            setTimeout(() => {
                const defaultId = defaultScene;
                let floor = 1;
                if (defaultId >= 10 && defaultId <= 19) floor = 2;
                else if (defaultId >= 20) floor = 3;

                const floor1Nav = document.getElementById('floor1-nav');
                const floor2Nav = document.getElementById('floor2-nav');
                const floor3Nav = document.getElementById('floor3-nav');
                const floorButtons = document.querySelectorAll('.floor-toggle .btn');

                if (floor1Nav && floor2Nav && floor3Nav) {
                    if (floor === 1) {
                        floor1Nav.style.display = 'block';
                        floor2Nav.style.display = 'none';
                        floor3Nav.style.display = 'none';
                        if (floorButtons.length >= 3) {
                            floorButtons[0].style.background = 'white';
                            floorButtons[0].style.color = '#FF5D07';
                            floorButtons[1].style.background = 'transparent';
                            floorButtons[1].style.color = 'white';
                            floorButtons[2].style.background = 'transparent';
                            floorButtons[2].style.color = 'white';
                        }
                    } else if (floor === 2) {
                        floor1Nav.style.display = 'none';
                        floor2Nav.style.display = 'block';
                        floor3Nav.style.display = 'none';
                        if (floorButtons.length >= 3) {
                            floorButtons[0].style.background = 'transparent';
                            floorButtons[0].style.color = 'white';
                            floorButtons[1].style.background = 'white';
                            floorButtons[1].style.color = '#FF5D07';
                            floorButtons[2].style.background = 'transparent';
                            floorButtons[2].style.color = 'white';
                        }
                    } else {
                        floor1Nav.style.display = 'none';
                        floor2Nav.style.display = 'none';
                        floor3Nav.style.display = 'block';
                        if (floorButtons.length >= 3) {
                            floorButtons[0].style.background = 'transparent';
                            floorButtons[0].style.color = 'white';
                            floorButtons[1].style.background = 'transparent';
                            floorButtons[1].style.color = 'white';
                            floorButtons[2].style.background = 'white';
                            floorButtons[2].style.color = '#FF5D07';
                        }
                    }
                }

                // Set active button
                const currentFloorNav = floor === 1 ? 'floor1-nav' : (floor === 2 ? 'floor2-nav' : 'floor3-nav');
                const buttons = document.querySelectorAll(`#${currentFloorNav} .btn`);

                buttons.forEach((btn, index) => {
                    let expectedId = index + 1;
                    if (floor === 2) expectedId = index + 10;
                    if (floor === 3) expectedId = index + 20;
                    if (expectedId == defaultId) {
                        btn.classList.add('active-nav');
                        btn.style.background = 'white';
                        btn.style.color = '#FF5D07';
                    }
                });
            }, 100);

            // Inisialisasi carousel setelah display lantai di-set
            setTimeout(() => {
                initCarousel('floor1-nav');
                initCarousel('floor2-nav');
                initCarousel('floor3-nav');
            }, 300);
        });
    </script>