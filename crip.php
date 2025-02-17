<?php include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login')</script>";
  echo "<script>location='index.php'</script>";
  exit();
} ?>


<?php
// Proses pencarian data untuk tabel subkriteria
$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$subkriteria = array();

if ($keyword) {
  $query = $koneksi->prepare("SELECT * FROM subkriteria LEFT JOIN kriteria ON subkriteria.kode_kriteria = kriteria.kode_kriteria WHERE kriteria.nama_kriteria LIKE ? OR subkriteria.kode_kriteria LIKE ? ORDER BY kriteria.kode_kriteria ASC");
  $searchTerm = "%" . $keyword . "%";
  $query->bind_param('ss', $searchTerm, $searchTerm);
  $query->execute();
  $ambilSubkriteria = $query->get_result();
} else {
  $ambilSubkriteria = $koneksi->query("SELECT * FROM subkriteria LEFT JOIN kriteria ON subkriteria.kode_kriteria = kriteria.kode_kriteria ORDER BY kriteria.kode_kriteria ASC, subkriteria.nilai_subkriteria ASC");

}

while ($tiap = $ambilSubkriteria->fetch_assoc()) {
  $subkriteria[] = $tiap;
}

include 'header.php';
?>

<!-- MAIN -->
<main>
    <h1 class="title">Subkriteria</h1>
    <section class="description">
        <p>
            Pada halaman ini, pengguna dapat menginputkan subkriteria. Subkriteria merupakan bagian yang lebih spesifik
            dari kriteria utama. Kolom 'Nilai Subkriteria' menunjukkan bobot atau nilai yang diberikan pada setiap
            subkriteria, yang menunjukkan preferensi atau tingkatan kepentingan dalam perhitungan SAW untuk
            menentukan skor akhir.

            Pengguna hanya perlu menginput <strong>Kode Kriteria, Nama Subkriteria, dan Nilai Subkriteria</strong>.
            Sementara itu, data seperti <strong>Nama Kriteria, Atribut Kriteria, dan Bobot Kriteria</strong> akan secara
            <strong>otomatis </strong>terisi berdasarkan <strong>data kriteria yang telah diinputkan
                sebelumnya.</strong>
        </p>
    </section>
    <a href="crip_tambah.php" class="btn btn1 button1">Tambah Data (+)</a>
    <table id="tabelku">
        <thead>
            <tr>
                <th>Kode Kriteria</th>
                <th>Nama Subkriteria</th>
                <th>Nilai Subkriteria</th>
                <th>Nama Kriteria</th>
                <th>Atribut Kriteria</th>
                <th>Bobot Kriteria</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subkriteria as $key => $value): ?>
            <?php
                        $color = "";
                        switch ($value['kode_kriteria']) {
                          case 'C1':
                            $color = '#D9DDDC';
                            break;
                          case 'C2':
                            $color = '#D6CF7';
                            break;
                          case 'C3':
                            $color = '#D9DDDC';
                            break;
                          case 'C4':
                            $color = '#D6CF7';
                            break;
                          case 'C5':
                            $color = '#D9DDDC';
                            break;
                          default:
                            $color = '#D6CF7';
                            break;
                        }
                        ?>
            <tr style="background-color: <?= $color?>;">
                <td><?php echo $value['kode_kriteria']; ?></td>
                <td><?php echo $value['nama_subkriteria']; ?></td>
                <td><?php echo $value['nilai_subkriteria']; ?></td>
                <td><?php echo $value['nama_kriteria']; ?></td>
                <td><?php echo $value['atribut_kriteria']; ?></td>
                <td><?php echo $value['bobot_kriteria']; ?></td>
                <td>
                    <a href="crip_ubah.php?id=<?php echo $value["id_subkriteria"] ?>" class="btn btn1">Ubah</a>
                    <a href="crip_hapus.php?id=<?php echo $value["id_subkriteria"] ?>" class="btn btn1">Hapus</a>
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