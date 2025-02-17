<?php include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda harus login')</script>";
    echo "<script>location='index.php'</script>";
    exit();
} ?>

<?php
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

$kriteria = array();
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $kriteria[] = $tiap;
}

$subkriteria = array();
$ambil = $koneksi->query("SELECT * FROM subkriteria");
while ($tiap = $ambil->fetch_assoc()) {
    $subkriteria[] = $tiap;
}
$nka = array();
foreach ($alternatif as $key => $peralternatif) {
    $kode_alternatif = $peralternatif["kode_alternatif"];
    $nama_alternatif = $peralternatif["nama_alternatif"];
    foreach ($kriteria as $key => $perkriteria) {
        $kode_kriteria = $perkriteria['kode_kriteria'];

        $ambil = $koneksi->query("SELECT * FROM nilai LEFT JOIN subkriteria ON nilai.id_subkriteria=subkriteria.id_subkriteria
            WHERE kode_alternatif='$kode_alternatif' AND nilai.kode_kriteria='$kode_kriteria' ORDER BY kode_alternatif ASC") or die(mysqli_error($koneksi));
        $nilai = $ambil->fetch_assoc();

        $nka[$kode_alternatif]['kode_alternatif'] = $kode_alternatif;
        $nka[$kode_alternatif]['nama_alternatif'] = $nama_alternatif;
        if (empty($nilai)) {
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['id_subkriteria'] = "";
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['nama_subkriteria'] = "";
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['nilai_subkriteria'] = "";
        } else {
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['id_subkriteria'] = $nilai['id_subkriteria'];
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['nama_subkriteria'] = $nilai['nama_subkriteria'];
            $nka[$kode_alternatif]['nilai'][$kode_kriteria]['nilai_subkriteria'] = $nilai['nilai_subkriteria'];
        }
    }
}


include 'header.php';
?>

<!-- MAIN -->
<main>
    <h1 class="title">Nilai</h1>
    <section class="description">
        <p>
            Halaman ini berfungsi untuk menampilkan dan mengelola nilai dari setiap alternatif berdasarkan kriteria yang
            telah ditentukan. Dengan adanya dropdown, pengguna dapat dengan mudah mengubah nilai alternatif
            sesuai kebutuhan. Setelah melakukan perubahan data, pengguna menekan tombol <strong>Perbarui</strong>.</p>
    </section>
    <button class="btn btn1" name="update">Perbarui</button>
    <div class="container">
        <form method="POST">
            <table id="tabelku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Calon Penerima</th>
                        <?php foreach ($kriteria as $key => $value): ?>
                        <th><?php echo $value['nama_kriteria'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($nka as $kode_alternatif => $peralternatif): ?>
                    <tr>
                        <td><?php echo $nomor ?></td>
                        <td>
                            <?php echo $peralternatif['nama_alternatif'] ?>
                        </td>
                        <?php foreach ($peralternatif['nilai'] as $kode_kriteria => $nk): ?>
                        <td>
                            <select class="form-control"
                                name="nilai_subkriteria[<?php echo $kode_alternatif ?>][<?php echo $kode_kriteria ?>]">
                                <option value="">Pilih</option>
                                <?php foreach ($subkriteria as $key => $pc): ?>
                                <?php if ($pc['kode_kriteria'] == $kode_kriteria): ?>
                                <option value="<?php echo $pc['id_subkriteria'] ?>"
                                    <?php echo $pc['id_subkriteria'] == $nk['id_subkriteria'] ? "selected" : "" ?>>
                                    <?php echo $pc['nama_subkriteria'] ?> - <?php echo $pc['nilai_subkriteria'] ?>
                                </option>
                                <?php endif ?>
                                <?php endforeach ?>
                            </select>

                        </td>
                        <?php endforeach ?>
                    </tr>
                    <?php $nomor++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>
    </div>
    </div>
    </table>
</main>
<!-- MAIN -->
</section>
<!-- NAVBAR -->
<script src="js/script.js"></script>
</body>

</html>

<?php
if (isset($_POST["update"])) {
    $nilai_subkriteria = $_POST["nilai_subkriteria"];

    foreach ($nilai_subkriteria as $kode_alternatif => $peralternatif) {
        foreach ($peralternatif as $kode_kriteria => $id_subkriteria) {
            $ambl = $koneksi->query("SELECT * FROM nilai WHERE kode_alternatif='$kode_alternatif' AND kode_kriteria='$kode_kriteria' ");
            $ceknilai = $ambl->fetch_assoc();

            if (empty($ceknilai)) {
                $koneksi->query("INSERT INTO nilai (kode_alternatif,kode_kriteria,id_subkriteria) VALUES('$kode_alternatif', '$kode_kriteria', '$id_subkriteria') ");
            } else {
                $id_nilai = $ceknilai['id_nilai'];
                $koneksi->query("UPDATE nilai SET
                    id_subkriteria='$id_subkriteria'
                    WHERE id_nilai='$id_nilai'");
            }

            echo "<script>alert('nilai terupdate')</script>";
            echo "<script>location='nilai.php'</script>";
        }
    }
}
?>