<?php
include 'koneksi.php';

// Cek jika user sudah login
if (!isset($_SESSION['id_admin'])) {
  echo "<script>alert('Anda harus login')</script>";
  echo "<script>location='index.php'</script>";
  exit();
}

// Proses pencarian data
$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$alternatif = array();

if ($keyword) {
  $query = $koneksi->prepare("SELECT * FROM alternatif WHERE nama_alternatif LIKE ? OR kode_alternatif LIKE ? ORDER BY kode_alternatif ASC");
  $searchTerm = "%" . $keyword . "%";
  $query->bind_param('ss', $searchTerm, $searchTerm);
  $query->execute();
  $ambil = $query->get_result();
} else {
  $ambil = $koneksi->query("SELECT *, CAST(SUBSTRING(kode_alternatif, 2) AS UNSIGNED) AS kode_angka FROM alternatif ORDER BY kode_angka ASC");

}


while ($tiap = $ambil->fetch_assoc()) {
  $alternatif[] = $tiap;
}
include 'header.php';
?>

<!-- MAIN -->
<main>
    <h1 class="title">Alternatif</h1>
    <section class="description">
        <p>
            Pada halaman ini, pengguna dapat menginput <strong> nama kandidat </strong>atau
            <strong>calon penerima</strong> yang akan dievaluasi berdasarkan kriteria yang telah ditentukan. Setiap
            kandidat diberikan kode yang diawali dengan huruf 'A' diikuti angka, dan nama diinput sesuai dengan data
            calon penerima pemberdayaan ekonomi.
        </p>
    </section>
    <a href="alternatif_tambah.php" class="btn btn1 button1">Tambah Data (+)</a>
    <table id="tabelku" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alternatif as $key => $value): ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $value['kode_alternatif']; ?></td>
                <td><?php echo $value['nama_alternatif']; ?></td>
                <td>
                    <a href="alternatif_ubah.php?kode=<?php echo $value['kode_alternatif']; ?>"
                        class="btn btn1  btn-warning">Ubah</a>
                    <a href="alternatif_hapus.php?kode=<?php echo $value['kode_alternatif']; ?>"
                        class="btn btn1 btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<!-- MAIN -->
</section>

<!-- SCRIPTS -->
<script src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#tabelku').DataTable({
        searching: false, // Disable default search as PHP handles it
        paging: true,
        info: true
    });
});
</script>
</body>

</html>