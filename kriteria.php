<?php include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login')</script>";
  echo "<script>location='index.php'</script>";
  exit();
}

// Proses pencarian data
$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$kriteria = array();

if ($keyword) {
  $query = $koneksi->prepare("SELECT * FROM kriteria WHERE nama_kriteria LIKE ? OR kode_kriteria LIKE ? ORDER BY kode_kriteria ASC");
  $searchTerm = "%" . $keyword . "%";
  $query->bind_param('ss', $searchTerm, $searchTerm);
  $query->execute();
  $ambil = $query->get_result();
} else {
  $ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
}

while ($tiap = $ambil->fetch_assoc()) {
  $kriteria[] = $tiap;
}
include 'header.php';
?>
<!-- MAIN -->
<main>
    <h1 class="title">Kriteria</h1>
    <section class="description">
        <p>
            Pada halaman ini, pengguna dapat menginputkan kriteria dan bobot kriteria berdasarkan
            kesepakatan yang disesuaikan dengan keadaan warga setempat. Bobot kriteria apabila dijumlahkan maka harus
            bernilai 1. Kriteria dikategorikan ke dalam dua atribut, yaitu <strong>benefit</strong> (keuntungan)
            dan <strong>cost</strong> (biaya). Benefit berarti semakin tinggi nilai bobotnya, maka semakin baik,
            sedangkan cost berarti semakin rendah nilai bobotnya, maka semakin baik.
        </p>
    </section>
    <a href="kriteria_tambah.php" class="btn btn1 button1">Tambah Data (+)</a>
    <table id="tabelku">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Atribut</th>
                <th>Bobot</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kriteria as $key => $value): ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $value['kode_kriteria']; ?></td>
                <td><?php echo $value['nama_kriteria']; ?></td>
                <td><?php echo $value['atribut_kriteria']; ?></td>
                <td><?php echo $value['bobot_kriteria']; ?></td>
                <td>
                    <a href="kriteria_ubah.php?kode=<?php echo $value["kode_kriteria"] ?>"
                        class="btn btn1  btn-warning">Ubah</a>
                    <a href="kriteria_hapus.php?kode=<?php echo $value["kode_kriteria"] ?>"
                        class="btn btn1 btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
    </table>
</main>
<!-- MAIN -->
</section>
<!-- NAVBAR -->
<script src="js/script.js"></script>
</body>

</html>