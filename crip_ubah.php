<?php include 'koneksi.php'; 
if(!isset($_SESSION['id_admin'])){
  echo "<script>alert('Anda harus login')</script>";
  echo"<script>location='index.php'</script>";
  exit();
}?>

<?php
$id = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM subkriteria WHERE id_subkriteria='$id' ");
$subkriteria = $ambil->fetch_assoc();
?>

<?php
$kriteria = array();
$atribut_kriteria = array();
$bobot_kriteria = array();
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while($tiap = $ambil->fetch_assoc())
{
    $kriteria[]= $tiap;
}
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
            <h3>Ubah Subkriteria</h3>
            <div class="tabelcrud">
                <form method="post">
                    <label for="kode_kriteria">Atribut Kriteria</label>
                    <select class="form-control" name="kode_kriteria" placeholder="Kode Kriteria....">
                        <option value="">Pilih</option>
                        <?php foreach ($kriteria as $key => $value): ?>
                        <option value="<?php echo $value["kode_kriteria"] ?>"
                            <?php echo $value['kode_kriteria']==$subkriteria['kode_kriteria']? "selected" : "" ?>>
                            <?php echo $value["kode_kriteria"] ?> - <?php echo $value["nama_kriteria"] ?>
                        </option>
                        <?php endforeach ?>
                    </select>

                    <label for="nama_subkriteria">Nama Subkriteria</label>
                    <input type="text" name="nama_subkriteria" placeholder="Nama Sub Kriteria..."
                        value="<?php echo $subkriteria['nama_subkriteria'] ?>">

                    <label for="nilai_subkriteria">Nilai Subkriteria</label>
                    <input type="text" name="nilai_subkriteria" placeholder="Bobot Kriteria..."
                        value="<?php echo $subkriteria['nilai_subkriteria'] ?>">

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
    $nama_subkriteria = $_POST["nama_subkriteria"];
    $nilai_subkriteria = $_POST["nilai_subkriteria"];


    // $koneksi->query("UPDATE subkriteria SET kode_kriteria = '$kode_kriteria', nama_kriteria = '$nama_subkriteria', nilai_subkriteria = '$nilai_subkriteria' WHERE id_subkriteria='$id'");
    // $koneksi->query("UPDATE subkriteria SET kode_kriteria = '$kode_kriteria', nama_kriteria = '$nama_subkriteria', nilai_subkriteria = '$nilai_subkriteria' WHERE id_subkriteria='$id'");
    $query = "UPDATE subkriteria SET kode_kriteria = '$kode_kriteria', nama_subkriteria = '$nama_subkriteria', nilai_subkriteria = '$nilai_subkriteria' WHERE id_subkriteria='$id'";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil disimpan')</script>";
        echo "<script>location='crip.php'</script>";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }
}
?>