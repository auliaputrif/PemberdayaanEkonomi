<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Correct Font Awesome link -->
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
                <h2 class="title">Buat Akun</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Masukkan nama</h5>
                        <input type="text" class="input" name="nama" required />
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="username" required />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password" required />
                    </div>
                </div>
                <a href="index.php">Login</a>
                <button type="submit" class="btn" name="daftar">Daftar</button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>

<?php
if (isset($_POST["daftar"])) {
    // Ambil data dari form
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashedPassword = sha1($password);

    // Periksa apakah username sudah terdaftar
    $ambil = $koneksi->query("SELECT * FROM admin WHERE username = '$username'");
    if ($ambil->num_rows > 0) {
        // Jika username sudah ada
        echo "<script>alert('Username sudah terdaftar!');</script>";
        echo "<script>location='registrasi.php';</script>";
    } else {
        // Jika username belum ada, simpan akun baru
        $simpan = $koneksi->query("INSERT INTO admin (username, password, nama) VALUES ('$username', '$hashedPassword', '$nama')");

        echo "<script>alert('Akun berhasil dibuat, silahkan login');</script>";
        echo "<script>location='index.php';</script>";
    }
}
?>