<?php
include 'koneksi.php';

$kode = $_GET['kode'];

$koneksi->query("DELETE FROM kriteria WHERE kode_kriteria='$kode' ");
echo "<script>alert('kriteria terhapus')</script>";
echo "<script>location='kriteria.php'</script>";

?>