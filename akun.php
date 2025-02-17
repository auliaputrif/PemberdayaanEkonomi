<?php
include 'koneksi.php';

if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login');</script>";
  echo "<script>location='index.php';</script>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LAZ Al-Muthi'in</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/crud.css" />
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

        <div class="container-profil">
            <div class="login-content">
                <form method="post" class="form-profile">
                    <div class="profile-img-container">
                        <img src="image/profile.png" class="profile-img" />
                    </div>
                    <h2 class="title">Profil</h2>

                    <!-- Username Input -->
                    <div class="input-profil-div">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" name="username" class="input-profil"
                            value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required />
                    </div>

                    <!-- Password Input -->
                    <div class="input-profil-div">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" class="input-profil"
                            placeholder="Kosongkan jika tidak ingin mengubah password" />
                    </div>

                    <!-- Full Name Input -->
                    <div class="input-profil-div">
                        <label for="nama"><i class="fas fa-user-tag"></i> Nama Lengkap</label>
                        <input type="text" name="nama" class="input-profil"
                            value="<?php echo htmlspecialchars($_SESSION['nama']); ?>" required />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn" name="ubah">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <script src="js/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

</body>

</html>

<?php
if (isset($_POST["ubah"])) {
  $id_admin = $_SESSION['id_admin'];
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = $_POST['password'];
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

  // Perbarui data admin
  if (empty($password)) {
    // Jika password tidak diubah
    $query = "UPDATE admin SET username='$username', nama='$nama' WHERE id_admin='$id_admin'";
  } else {
    // Jika password diubah
    $password_hashed = sha1($password); // Pastikan hashing sesuai standar
    $query = "UPDATE admin SET username='$username', password='$password_hashed', nama='$nama' WHERE id_admin='$id_admin'";
  }

  if ($koneksi->query($query)) {
    // Perbarui session
    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $nama;
    echo "<script>alert('Akun telah diubah');</script>";
    echo "<script>location='akun.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat memperbarui akun');</script>";
  }
}
?>