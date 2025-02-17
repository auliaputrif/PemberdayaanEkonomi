<?php
include 'koneksi.php';

$id = $_GET['id'];

$koneksi->query("DELETE FROM subkriteria WHERE id_subkriteria='$id' ");
echo "<script>alert('subkriteria terhapus')</script>";
echo "<script>location='crip.php'</script>";

?>