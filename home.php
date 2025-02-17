<?php include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login')</script>";
  echo "<script>location='index.php'</script>";
  exit();
}
$dataKriteria = mysqli_query($koneksi, "SELECT * FROM kriteria");
$jumlahDataKriteria = mysqli_num_rows($dataKriteria);

$dataSubkriteria = mysqli_query($koneksi, "SELECT * FROM subkriteria");
$jumlahDataSubkriteria = mysqli_num_rows($dataSubkriteria);

$dataAlternatif = mysqli_query($koneksi, "SELECT * FROM alternatif");
$jumlahDataAlternatif = mysqli_num_rows($dataAlternatif);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LAZ Al-Muthi'in</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/crud.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <!-- Sidebar content -->
        <a href="#" class="brand"><img src="image/logo_kecil.png" class="icon" />LAZ Al-Muthi'in</a>
        <ul class="side-menu">
            <li>
                <a href="home.php" class="active">
                    <p style="width: 100%; text-align: center">Beranda</p>
                </a>
            </li>
            <li class="divider" data-text="Menu"></li>
            <li><a href="kriteria.php"><i class="fas fa-list-check icon"></i>Kriteria</a></li>
            <li><a href="alternatif.php"><i class="fas fa-users icon"></i>Alternatif</a></li>
            <li><a href="crip.php"><i class="fas fa-sliders-h icon"></i>Subkriteria</a></li>
            <li><a href="nilai.php"><i class="fas fa-chart-line icon"></i>Nilai</a></li>
            <li class="divider" data-text="Hasil"></li>
            <li><a href="saw1.php"><i class="fas fa-trophy icon"></i>Perangkingan</a></li>
        </ul>
        <div class="ads">
            <div class="wrapper">
                <a href="cetak.php" class="btn-upgrade"><i class="fas fa-solid fa-print"></i>&nbsp;Cetak</a>
                <p>
                    Periksa<span> Kembali</span> Hasil Pekerjaan <span>Anda</span>
                </p>
            </div>
        </div>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="nav-search">
            <i class="fas fa-solid fa-bars toggle-sidebar"></i>
            <span class="divider"></span>
            <div class="profile">
                <img src="image/profile.png" alt="Profile Picture" />
                <ul class="profile-link">
                    <li><a href="akun.php"><i class="fas fa-regular fa-circle-user icon"></i>Profile</a></li>
                    <li><a href="logout.php"><i class="fas fa-solid fa-right-from-bracket"></i>Logout</a></li>
                </ul>
            </div>
            </div>
        </nav>
        <main>
            <h2 class="welcome-message">
                Selamat Datang di <span>Lembaga Amil Zakat Al-Muthi'in</span>
            </h2>
            <p class="short-description">Aplikasi ini dirancang untuk membantu <strong>Lembaga Amil Zakat
                    Al-Muthi'in</strong> dalam menentukan penerima program pemberdayaan ekonomi. Mari bersama-sama
                mewujudkan pemberdayaan ekonomi yang lebih baik melalui zakat yang tepat guna! Berikut merupakan
                langkah-langkah untuk menggunakan Aplikasi ini.</p>

            <div class="card-container">
                <a href="kriteria.php" class="card">
                    <div class="icon"><i class="fa-solid fa-1"></i></div>
                    <h3 class="card-title">Kriteria</h3>
                    <p class="card-content">Kriteria merupakan faktor-faktor yang menjadi dasar penilaian yang
                        membantu dalam mengevaluasi setiap alternatif. Kriteria dikategorikan ke dalam dua atribut,
                        yaitu benefit (keuntungan) dan cost (biaya). Benefit berarti semakin tinggi nilai bobotnya, maka
                        semakin baik, sedangkan cost berarti semakin rendah nilai bobotnya, maka semakin baik. Kriteria
                        untuk penentuan ini diperoleh dari kesepakatan bersama.</p>
                    <p class="data-count">Jumlah Data: <?= $jumlahDataKriteria ?></p>
                </a>

                <a href="alternatif.php" class="card">
                    <div class="icon"><i class="fa-solid fa-2"></i></div>
                    <h3 class="card-title">Alternatif</h3>
                    <p class="card-content">Alternatif merupakan kandidat
                        atau calon yang akan dievaluasi berdasarkan kriteria yang telah ditentukan. Alternatif
                        dalam
                        penentuan ini diperoleh dari data nama calon penerima pemberdayaan ekonomi.</p>
                    <p class="data-count">Jumlah Data: <?= $jumlahDataAlternatif ?></p>
                </a>

                <a href="crip.php" class="card">
                    <div class="icon"><i class="fas fa-3"></i></div>
                    <h3 class="card-title">Subkriteria</h3>
                    <p class="card-content">Subkriteria adalah turunan dari kriteria utama yang digunakan
                        untuk memperinci dan menilai alternatif secara lebih spesifik.</p>
                    <p class="data-count">Jumlah Data: <?= $jumlahDataSubkriteria ?></p>
                </a>

                <div class="card-container">

                    <a href="nilai.php" class="card">
                        <div class="icon"><i class="fas fa-4"></i></div>
                        <h3 class="card-title">Nilai</h3>
                        <p class="card-content">Pada halaman nilai merupakan proses penilaian setiap alternatif
                            berdasarkan kriteria yang telah ditentukan. Nilai ini akan dinormalisasi dan
                            dihitung untuk
                            mendapatkan peringkat alternatif terbaik.</p>
                    </a>

                    <a href="saw1.php" class="card">
                        <div class="icon"><i class="fas fa-5"></i></div>
                        <h3 class="card-title">Perangkingan</h3>
                        <p class="card-content">Perangkingan dalam metode Simple Additive Weighting (SAW) adalah
                            langkah
                            terakhir dalam proses pengambilan keputusan, di mana setiap alternatif dihitung skor
                            akhirnya dan diurutkan dari yang memiliki nilai tertinggi hingga terendah.
                            Alternatif dengan
                            nilai tertinggi menjadi pilihan terbaik.</p>
                    </a>

                    <a href="cetak.php" class="card">
                        <div class="icon"><i class="fas fa-6"></i></div>
                        <h3 class="card-title">Cetak</h3>
                        <p class="card-content">Setelah mendapatkan hasil perangkingan, fitur cetak laporan atau
                            ekspor
                            hasil digunakan untuk menyajikan perhitungan dalam format yang lebih formal.</p>
                    </a>
                </div>
            </div>
        </main>

    </section>
    <!-- NAVBAR -->
    <!-- SCRIPTS -->
    <script src="js/script.js"></script>
</body>

</html>