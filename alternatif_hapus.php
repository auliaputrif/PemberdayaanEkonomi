<?php
include 'koneksi.php';

$kode = $_GET['kode'];

$koneksi->query("DELETE FROM alternatif WHERE kode_alternatif='$kode' ");
echo "<script>alert('alternatif terhapus')</script>";
echo "<script>location='alternatif.php'</script>";

?>