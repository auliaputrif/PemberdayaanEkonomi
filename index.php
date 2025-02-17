<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Correct Font Awesome link -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>


<body>
    <img class="wave" src="image/ombak.png" />
    <div class="container">
        <div class="img">
            <img src="image/logo_masjid.png" />
        </div>
        <div class="login-content">
            <form method="post">
                <img src="image/profile.png" />
                <h2 class="title">Selamat Datang</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Nama Pengguna</h5>
                        <input type="text" class="input" name="username" required />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Kata Sandi</h5>
                        <input type="password" class="input" name="password" required />
                    </div>
                </div>
                <button type="submit" class="btn" name="login">Masuk</button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>

<?php
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $password = sha1($password);

  $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$username' AND password='$password' ");
  $cekadmin = $ambil->fetch_assoc();

  if (empty($cekadmin)) {
    echo "<script>alert('Akun salah!')</script>";
    echo "<script>location='index.php'</script>";
  } else {
    $_SESSION['id_admin'] = $cekadmin['id_admin'];
    $_SESSION['username'] = $cekadmin['username'];
    $_SESSION['nama'] = $cekadmin['nama'];
    echo "<script>alert('Akun benar, berhasil login!')</script>";
    echo "<script>location='home.php'</script>";
  }
}
?>