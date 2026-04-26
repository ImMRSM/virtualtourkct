<?php
include 'header.php';
include 'koneksi.php';

// Ambil data pegawai dari database (tabel pegawai jika ada)
// Atau buat array manual sesuai dengan ruangan yang ada di virtual tour
$pegawai = [
    // PIMPINAN (Lantai 3)
    [
        'nama' => 'Juperianto Marbun Banjarnahor, S.Sos., M.Si.',
        'jabatan' => 'Camat Cimahi Tengah',
        'tugas' => 'Memimpin penyelenggaraan pemerintahan, pembangunan, dan kemasyarakatan di wilayah Kecamatan Cimahi Tengah.',
        'ruangan' => 'Ruang Camat',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/wFKtbY9s/camat.jpg',
        'kategori' => 'pimpinan'
    ],
    [
        'nama' => 'Dian Sri Redjeki, S.P, M.K.M.',
        'jabatan' => 'Sekretaris Camat',
        'tugas' => 'Mengkoordinasikan urusan administrasi, keuangan, dan pelayanan internal.',
        'ruangan' => 'Ruang Sekretaris',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/KzfhmY75/sekcam.jpg',
        'kategori' => 'pimpinan'
    ],

    // SEKSI PELAYANAN UMUM (Lantai 1 - Yanum)
    [
        'nama' => 'Herry Setiawan, A.K.S., M.M.',
        'jabatan' => 'Kasi Pelayanan Umum (Yanum)',
        'tugas' => 'Melayani administrasi kependudukan (KTP, KK, Akta Kelahiran/Kematian) dan perizinan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/ZRQwnwGN/yanum1.jpg',
        'kategori' => 'pelayanan'
    ],
    [
        'nama' => 'Dani Kurniawan',
        'jabatan' => 'Pengolah Data Pelayanan',
        'tugas' => 'Melayani pembuatan KTP, KK, dan akta-akta kependudukan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/fzPSnJpK/yanum2.jpg',
        'kategori' => 'pelayanan'
    ],
    [
        'nama' => 'Abdurahman Shiddiq, S.I.Kom.',
        'jabatan' => 'Operator Layanan Operasional',
        'tugas' => 'Melayani perizinan usaha, rekomendasi, dan surat keterangan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/4ZYzR1F0/yanum3.jpg',
        'kategori' => 'pelayanan'
    ],
    [
        'nama' => 'Nurfatia Dwi, S.Psi',
        'jabatan' => 'Staff Pelayanan Umum',
        'tugas' => 'Melayani perizinan usaha, rekomendasi, dan surat keterangan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/r2LNdpG0/yanum4.jpg',
        'kategori' => 'pelayanan'
    ],
    [
        'nama' => 'Dimas',
        'jabatan' => 'Staff Pelayanan Umum',
        'tugas' => 'Melayani perizinan usaha, rekomendasi, dan surat keterangan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/KjZZfCNr/yanum5.jpg',
        'kategori' => 'pelayanan'
    ],
    [
        'nama' => 'Tsania',
        'jabatan' => 'Staff Pelayanan Umum',
        'tugas' => 'Melayani perizinan usaha, rekomendasi, dan surat keterangan.',
        'ruangan' => 'Ruang Pelayanan Umum',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/bgdkPs5s/yanum6.jpg',
        'kategori' => 'pelayanan'
    ],

    // SEKSI PEMERINTAHAN (Lantai 2 - Kasi Pemtra)
    [
        'nama' => 'Seta Dewa Nugroho, S.STP., M.Si.',
        'jabatan' => 'Kasi Pemerintahan (Pemtra)',
        'tugas' => 'Mengelola urusan pemerintahan, pembinaan desa/kelurahan, dan kewilayahan.',
        'ruangan' => 'Ruang Kasi Pemtra',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/pvB13sMH/pemtra1.jpg',
        'kategori' => 'pemerintahan'
    ],
    [
        'nama' => 'Tatang Suwardi',
        'jabatan' => 'Staff Pemerintahan',
        'tugas' => 'Membantu administrasi pemerintahan dan kewilayahan.',
        'ruangan' => 'Ruang Kasi Pemtra',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/xS2N5Ddr/pemtra2.jpg',
        'kategori' => 'pemerintahan'
    ],
    [
        'nama' => 'Doni Esliyana Sandhi',
        'jabatan' => 'Staff Pemerintahan',
        'tugas' => 'Membantu administrasi pemerintahan dan kewilayahan.',
        'ruangan' => 'Ruang Kasi Pemtra',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/vC8vDRXR/pemtra3.jpg',
        'kategori' => 'pemerintahan'
    ],

    // SEKSI PEMBERDAYAAN (Lantai 2 - Kasi Pemberdayaan)
    [
        'nama' => 'Firmansyah, S.Sos.',
        'jabatan' => 'Kasi Pemberdayaan Masyarakat',
        'tugas' => 'Melaksanakan program pemberdayaan masyarakat dan kesejahteraan sosial.',
        'ruangan' => 'Ruang Kasi Pemberdayaan',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/gL8vLSJN/pemb1.jpg',
        'kategori' => 'pemberdayaan'
    ],
    [
        'nama' => 'Tri Cahya Christanto, S.T.',
        'jabatan' => 'Staff Pemberdayaan',
        'tugas' => 'Mendampingi program-program pemberdayaan masyarakat.',
        'ruangan' => 'Ruang Kasi Pemberdayaan',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/0p90VZ0t/pemb2.jpg',
        'kategori' => 'pemberdayaan'
    ],
    [
        'nama' => 'Boby Arief Rakhman',
        'jabatan' => 'Staff Pemberdayaan',
        'tugas' => 'Mendampingi program-program pemberdayaan masyarakat.',
        'ruangan' => 'Ruang Kasi Pemberdayaan',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/XfxhwJSZ/pemb3.jpg',
        'kategori' => 'pemberdayaan'
    ],

    // SEKSI EKONOMI (Lantai 2 - Kasi Eksos)
    [
        'nama' => 'Nandang Rudayat, S.E., M.Si.',
        'jabatan' => 'Kasi Ekonomi dan Kesejahteraan Sosial (Eksos)',
        'tugas' => 'Mengelola program pembangunan dan ekonomi masyarakat, serta pengembangan UMKM.',
        'ruangan' => 'Ruang Kasi Eksos',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/j9M9by1n/eksos1.jpg',
        'kategori' => 'ekonomi'
    ],
    [
        'nama' => 'Rani Idaman Eka Putri, S.E.',
        'jabatan' => 'Pengelola Data',
        'tugas' => 'Mendampingi program ekonomi dan pengembangan UMKM.',
        'ruangan' => 'Ruang Kasi Eksos',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/dwYWFqdv/eksos2.jpg',
        'kategori' => 'ekonomi'
    ],
    [
        'nama' => 'Diaz Nafi Satya, S.Pd.',
        'jabatan' => 'Staff Eksos',
        'tugas' => 'Mendampingi program ekonomi dan pengembangan UMKM.',
        'ruangan' => 'Ruang Kasi Eksos',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/QjCb7qk2/eksos3.jpg',
        'kategori' => 'ekonomi'
    ],
    [
        'nama' => 'Dicky Nugraha, S.IP.',
        'jabatan' => 'Staff Eksos',
        'tugas' => 'Mendampingi program ekonomi dan pengembangan UMKM.',
        'ruangan' => 'Ruang Kasi Eksos',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/YTpFGwtd/eksos4.jpg',
        'kategori' => 'ekonomi'
    ],

    // SEKSI SARPRAS (Lantai 2 - Kasi Sarpras)
    [
        'nama' => ' Eman Wahidin, S.Kom.',
        'jabatan' => 'Kasi Sarana dan Prasarana (Sarpras)',
        'tugas' => 'Bertanggung jawab atas pemeliharaan sarana dan prasarana kantor.',
        'ruangan' => 'Ruang Kasi Sarpras',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/GvYxJMbQ/sarpras1.jpg',
        'kategori' => 'sarpras'
    ],
    [
        'nama' => 'Andrea Adhitya Heriyadi Putera, S.H., M.A.P.',
        'jabatan' => 'Pengelola Penataan Sarpras',
        'tugas' => 'Bertanggung jawab atas pemeliharaan sarana dan prasarana kantor.',
        'ruangan' => 'Ruang Kasi Sarpras',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/KpYfgP3m/sarpras2.jpg',
        'kategori' => 'sarpras'
    ],
    [
        'nama' => 'Priyan Dwi, S.IP.',
        'jabatan' => 'Staff Sarpras',
        'tugas' => 'Bertanggung jawab atas pemeliharaan sarana dan prasarana kantor.',
        'ruangan' => 'Ruang Kasi Sarpras',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/67VwRqWX/sarpras3.jpg',
        'kategori' => 'sarpras'
    ],

    // PELAYANAN PKH (Lantai 2)
    // [
    //     'nama' => 'Yoshinta Lusiari, S.Tr.Sos.',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mengelola Program Keluarga Harapan (PKH), pendataan, dan verifikasi penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh1.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Didin Cahyanto',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh2.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Eneng',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh3.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Riesta Putri',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh4.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Lita Marliani',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh5.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Oky Aji Pamungkas, S.Tr.Sos.',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh5.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Shinta Hartono, S.Tr.Sos.',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh5.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Elis',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh5.jpg',
    //     'kategori' => 'pkh'
    // ],
    // [
    //     'nama' => 'Lia',
    //     'jabatan' => 'Petugas PKH',
    //     'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
    //     'ruangan' => 'Ruang PKH',
    //     'lantai' => 2,
    //     'foto' => '../assets/img/pkh5.jpg',
    //     'kategori' => 'pkh'
    // ],

    // KASUBAG UMUM DAN KEPEGAWAIAN (Lantai 3)
    [
        'nama' => 'Andri Noviandi, S.Sos.',
        'jabatan' => 'Kasubag Umum dan Kepegawaian (Umpeg)',
        'tugas' => 'Mengelola administrasi kepegawaian, surat-menyurat, dan kearsipan.',
        'ruangan' => 'Ruang Kasubag Umpeg',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/prRVVSvk/umpeg1.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Nyindi Kartika Andriyani, S.Tr.IP.',
        'jabatan' => 'Pengelola Data',
        'tugas' => 'Mengelola perencanaan program, anggaran, dan pelaporan keuangan.',
        'ruangan' => 'Ruang Kasubag Umpeg',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/VYnPr6GM/umpeg2.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Sofyan Maulana, A.MD.',
        'jabatan' => 'Kustodian Barang Milik Daerah',
        'tugas' => 'Mengelola administrasi keuangan dan pelaporan.',
        'ruangan' => 'Ruang Kasubag Umpeg',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/99xD9q8K/umpeg3.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Fitriani',
        'jabatan' => 'Staff Umpeg',
        'tugas' => 'Mengelola perencanaan program, anggaran, dan pelaporan keuangan.',
        'ruangan' => 'Ruang Kasubag Umpeg',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/jPY2T3Gv/umpeg4.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Dadan Gunawan',
        'jabatan' => 'Keamanan',
        'tugas' => 'Mengelola perencanaan program, anggaran, dan pelaporan keuangan.',
        'ruangan' => 'Parkiran',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/HDBdDPmP/umpeg5.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Dedi Yudiana',
        'jabatan' => 'Keamanan',
        'tugas' => 'Mengelola perencanaan program, anggaran, dan pelaporan keuangan.',
        'ruangan' => 'Parkiran',
        'lantai' => 1,
        'foto' => 'https://i.ibb.co.com/zHLFrVKc/umpeg6.jpg',
        'kategori' => 'umpeg'
    ],
    [
        'nama' => 'Suheri',
        'jabatan' => 'Kebersihan',
        'tugas' => 'Mengelola perencanaan program, anggaran, dan pelaporan keuangan.',
        'ruangan' => 'Dapur',
        'lantai' => 2,
        'foto' => 'https://i.ibb.co.com/hR9m18hB/umpeg7.jpg',
        'kategori' => 'umpeg'
    ],

    // KASUBAG PROGRAM DAN KEUANGAN (Lantai 3)
    [
        'nama' => 'Lia Sutiawati, S.E., M.Si.',
        'jabatan' => 'Kasubag Program dan Keuangan (Progkeu)',
        'tugas' => 'Mengelola Program Keluarga Harapan (PKH), pendataan, dan verifikasi penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/mVCVr35q/progkeu1.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Ghianti Novita Maulina, S.E., M.M.',
        'jabatan' => 'Bendahara',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/qFFYKtNR/progkeu2.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Tin Gantini Dewi, S.A.P.',
        'jabatan' => 'Analis Perencanaan, Evaluasi, dan Pelaporan',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/MkNV7mqV/progkeu3.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Nazar Muzaqir Sukandar',
        'jabatan' => 'Staff Progkeu',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/Y7tKVYMT/progkeu4.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Reni Fusvita, S.A.P.',
        'jabatan' => 'Analis Laporan Keuangan',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/J8TY2xn/progkeu5.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Hadi Mulyana',
        'jabatan' => 'Pengelola Keuangan',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/Dgmsp937/progkeu6.jpg',
        'kategori' => 'progkeu'
    ],
    [
        'nama' => 'Yussy Sri Redjeki',
        'jabatan' => 'Staff Progkeu',
        'tugas' => 'Mendampingi peserta PKH dan memverifikasi data penerima manfaat.',
        'ruangan' => 'Ruang Kasubag Progkeu',
        'lantai' => 3,
        'foto' => 'https://i.ibb.co.com/Gf3JR8wk/progkeu7.jpg',
        'kategori' => 'progkeu'
    ]

];
?>

<!-- Hero Section Pegawai -->
<!-- <div class="py-5" style="background: linear-gradient(135deg, #FF5D07 0%, #ff8c42 100%);">
    <div class="container py-4 text-center text-white">
        <h1 class="display-4 fw-bold mb-3">Aparatur Kecamatan Cimahi Tengah</h1>
        <p class="lead mb-0">Mengenal lebih dekat para petugas yang siap melayani masyarakat</p>
    </div>
</div> -->

<!-- Section Struktur Organisasi -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">STURUKTUR ORGANISASI</h2>
        <p class="text-secondary">Pegawai Kecamatan Cimahi Tengah berdasarkan bidang dan ruangan</p>
    </div>

    <div class="custom-divider">
        <div class="divider-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Pilih Bagian -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="btn filter-btn active" data-filter="all"
                    style="background: #FF5D07; color: white; border-radius: 50px; padding: 8px 25px;">Semua</button>
                <button class="btn filter-btn" data-filter="pimpinan"
                    style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Pimpinan</button>
                <button class="btn filter-btn" data-filter="umpeg"
                    style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Umpeg</button>
                <button class="btn filter-btn" data-filter="progkeu"
                    style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Progkeu</button>
                <button class="btn filter-btn" data-filter="pemerintahan"
                    style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Pemtra</button>
                    <button class="btn filter-btn" data-filter="ekonomi"
                        style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Eksos</button>
                    <button class="btn filter-btn" data-filter="pelayanan"
                        style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Yanum</button>
                    <button class="btn filter-btn" data-filter="sarpras"
                        style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Sarpras</button>
                    <button class="btn filter-btn" data-filter="pemberdayaan"
                        style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">Pemberdayaan</button>
                    <!-- <button class="btn filter-btn" data-filter="pkh"
                        style="background: #e9ecef; color: #FF5D07; border-radius: 50px; padding: 8px 25px;">PKH</button> -->
            </div>
        </div>

       <!-- Grid Kartu Pegawai -->
<div class="row g-4" id="pegawai-container">
    <?php foreach ($pegawai as $index => $p): ?>
        <div class="col-lg-4 col-md-6 pegawai-item" data-category="<?= $p['kategori'] ?>">
            <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
                <div class="card-body text-center p-4">
                    <!-- Foto Pegawai -->
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center overflow-hidden rounded-circle"
                        style="width: 140px; height: 140px; background: linear-gradient(135deg, #FF5D07, #ff8c42);">
                        
                      <img src="<?= $p['foto'] ?>" 
                         alt="<?= $p['nama'] ?>" 
                         class="w-100 h-100"
                             style="object-fit: cover;"
                             onerror="this.src='https://co.com';">

                    </div>

                    <h5 class="fw-bold mb-1"><?= $p['nama'] ?></h5>
                    <p class="text-primary fw-semibold mb-2"><?= $p['jabatan'] ?></p>

                    <div class="mt-2">
                        <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-2 rounded-pill">
                            Lantai <?= $p['lantai'] ?> - <?= $p['ruangan'] ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <!-- Script untuk filter -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const pegawaiItems = document.querySelectorAll('.pegawai-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Update active state
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Update style button
                    filterButtons.forEach(btn => {
                        if (btn.classList.contains('active')) {
                            btn.style.background = '#FF5D07';
                            btn.style.color = 'white';
                        } else {
                            btn.style.background = '#e9ecef';
                            btn.style.color = '#FF5D07';
                        }
                    });

                    const filterValue = this.getAttribute('data-filter');

                    pegawaiItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'scale(1)';
                            }, 10);
                        } else {
                            item.style.opacity = '0';
                            item.style.transform = 'scale(0.9)';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .pegawai-item {
            transition: all 0.3s ease;
            opacity: 1;
            transform: scale(1);
        }

        .filter-btn {
            transition: all 0.2s ease;
            font-weight: 500;
            cursor: pointer;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 93, 7, 0.2);
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>

    <?php include 'footer.php'; ?>