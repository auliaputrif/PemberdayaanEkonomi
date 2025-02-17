<?php
include 'koneksi.php';
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda harus login')</script>";
    echo "<script>location='index.php'</script>";
    exit();
}

$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$alternatif = array();
$nama_alternatif = array();
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
    $nama_alternatif[$tiap['kode_alternatif']] = $tiap['nama_alternatif'];
    $alternatif[] = $tiap;
}

$kriteria = array();
$atribut_kriteria = array();
$bobot_kriteria = array();
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $atribut_kriteria[$tiap['kode_kriteria']] = $tiap['atribut_kriteria'];
    $bobot_kriteria[$tiap['kode_kriteria']] = $tiap['bobot_kriteria'];
    $kriteria[] = $tiap;
}

$nilai = array();
$ambil = $koneksi->query("SELECT * FROM nilai LEFT JOIN subkriteria ON nilai.id_subkriteria=subkriteria.id_subkriteria

    ORDER BY id_nilai ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $nilai[] = $tiap;
}

//echo "<pre>";
//print_r ($alternatif);
//print_r ($kriteria);
//print_r ($nilai);
//echo "</pre>";

$analisa = array();
foreach ($alternatif as $key => $peralternatif) {
    $kode_alternatif = $peralternatif['kode_alternatif'];

    foreach ($kriteria as $key => $perkriteria) {
        $kode_kriteria = $perkriteria['kode_kriteria'];

        foreach ($nilai as $key => $pernilai) {
            if ($pernilai['kode_alternatif'] == $kode_alternatif && $pernilai['kode_kriteria'] == $kode_kriteria) {
                $analisa[$kode_alternatif][$kode_kriteria] = $pernilai['nilai_subkriteria'];
            }
        }
    }
}

$nilai_kriteria = array();
foreach ($analisa as $kode_alternatif => $peralternatif) {
    foreach ($peralternatif as $kode_kriteria => $nilai) {
        $nilai_kriteria[$kode_kriteria][] = $nilai;
    }
}
$normalisasi = array();
foreach ($analisa as $kode_alternatif => $peralternatif) {
    foreach ($peralternatif as $kode_kriteria => $nilai) {
        if ($atribut_kriteria[$kode_kriteria] == "cost") {
            $normalisasi[$kode_alternatif][$kode_kriteria] = min($nilai_kriteria[$kode_kriteria]) / $nilai;
        } else {
            $normalisasi[$kode_alternatif][$kode_kriteria] = $nilai / max($nilai_kriteria[$kode_kriteria]);
        }
    }
}

$perangkingan = array();
foreach ($normalisasi as $kode_alternatif => $peralternatif) {

    $total = 0;
    foreach ($peralternatif as $kode_kriteria => $nilai_ternormalisasi) {
        $total += $nilai_ternormalisasi * $bobot_kriteria[$kode_kriteria];
    }
    $perangkingan[$kode_alternatif] = $total;
}

arsort($perangkingan);

//echo "<pre>";
//print_r($atribut_kriteria);
//print_r($nilai_kriteria);
//print_r($analisa);
//print_r($normalisasi);
//print_r($bobot_kriteria);
//print_r($perangkingan);
//echo "</pre>";
include 'header.php';
?>

<!-- MAIN -->
<main>
    <h1 class="title">Perangkingan</h1>
    <section class="description">
        <p>Halaman Perangkingan merupakan tahap akhir dari proses dalam sistem pendukung keputusan. Pada halaman ini,
            pengguna dapat melihat nama dan total nilai dari masing-masing alternatif yang telah diurutkan dari
            <strong>nilai terbesar hingga terkecil.</strong> Dengan tampilan ini, pengguna dapat dengan mudah menentukan
            calon penerima pemberdayaan ekonomi yang paling layak untuk diberikan bantuan.
        </p>
    </section>
    <form action="export_excel.php" method="post">
        <button type="submit">Ekspor ke Excel</button>
    </form>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Alternatif</h3>
                <table id="tabelku">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alternatif as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['kode_alternatif']; ?></td>
                            <td><?php echo $value['nama_alternatif']; ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Kriteria</h3>
                <table id="tabelku">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kriteria as $key => $value): ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['kode_kriteria']; ?></td>
                            <td><?php echo $value['nama_kriteria']; ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
            <h3>Nilai</h3>
            <table id="tabelku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        <?php foreach ($kriteria as $key => $value): ?>
                        <th><?php echo $value['nama_kriteria'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($analisa as $kode_alternatif => $peralternatif) : ?>
                    <tr>
                        <td><?php echo $nomor ?></td>
                        <td><?php echo $nama_alternatif[$kode_alternatif] ?></td>
                        <?php foreach ($peralternatif as $key => $nilai) : ?>
                        <td><?php echo $nilai ?></td>
                        <?php endforeach ?>
                    </tr>
                    <?php $nomor++ ?>
                    <?php endforeach ?>
                </tbody>
            </table>
            <br>
            <br> -->
    <table id="tabelku">
        <thead>
            <tr>
                <th>Rangking</th>
                <th>Alternatif</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php $rangking = 1; ?>
            <?php foreach ($perangkingan as $kode_alternatif => $totalnilai): ?>
            <tr>
                <td><?php echo $rangking ?></td>
                <td><?php echo $nama_alternatif[$kode_alternatif] ?></td>
                <td><?php echo $totalnilai ?></td>
            </tr>
            <?php $rangking++; ?>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
    </div>
</main>
<!-- MAIN -->
</section>
<!-- NAVBAR -->
<script src="js/script.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</body>

</html>