<?php include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login')</script>";
  echo "<script>location='index.php'</script>";
  exit();
} ?>

<?php
$kode = $_GET['kode'];

$ambil = $koneksi->query("SELECT * FROM kriteria WHERE kode_kriteria='$kode' ");
$kriteria = $ambil->fetch_assoc();

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

            <div class="nav-right">
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

        <!-- MAIN -->
        <main>
            <h3>Ubah Kriteria</h3>
            <div class="tabelcrud">
                <form method="post">
                    <label for="kode_kriteria">Kode Kriteria</label>
                    <input readonly type="text" name="kode_kriteria" placeholder="Kode Kriteria...."
                        value="<?php echo $kriteria['kode_kriteria'] ?>">

                    <label for="nama_kriteria">Nama Kriteria</label>
                    <input type="text" name="nama_kriteria" placeholder="Nama Kriteria..."
                        value="<?php echo $kriteria['nama_kriteria'] ?>">

                    <label for="atribut_kriteria">Atribut Kriteria</label>
                    <select name="atribut_kriteria">
                        <option value="">Pilih</option>
                        <option value="benefit"
                            <?php echo $kriteria['atribut_kriteria'] == 'benefit' ? 'selected' : "" ?>>Benefit</option>
                        <option value="cost" <?php echo $kriteria['atribut_kriteria'] == 'cost' ? 'selected' : "" ?>>
                            Cost</option>
                    </select>
                    <label for="bobot_kriteria">Bobot Kriteria</label>
                    <input type="text" name="bobot_kriteria" placeholder="Bobot Kriteria..."
                        value="<?php echo $kriteria['bobot_kriteria'] ?>">

                    <input type="submit" name="simpan">
                </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->
    <script src="js/script.js"></script>
</body>

</html>


<?php
if (isset($_POST["simpan"])) {
  $kode_kriteria = $_POST["kode_kriteria"];
  $nama_kriteria = $_POST["nama_kriteria"];
  $atribut_kriteria = $_POST["atribut_kriteria"];
  $bobot_kriteria = $_POST["bobot_kriteria"];

  $koneksi->query("UPDATE kriteria SET
                                nama_kriteria='$nama_kriteria',
                                atribut_kriteria='$atribut_kriteria',
                                bobot_kriteria='$bobot_kriteria'
                                WHERE kode_kriteria='$kode_kriteria'
                                ");

  echo "<script>alert('kriteria tersimpan')</script>";
  echo "<script>location='kriteria.php'</script>";
  echo "</script>";
}
?>