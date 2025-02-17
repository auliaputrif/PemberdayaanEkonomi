<?php
include 'koneksi.php';

//hapus session
session_destroy();
echo "<script>alert('Anda telah logout')</script>";
echo "<script>location='index.php'</script>";
?>