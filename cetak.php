<?php 
include 'koneksi.php';
if(!isset($_SESSION['id_admin'])){
    echo "<script>alert('Anda harus login')</script>";
    echo"<script>location='index.php'</script>";
    exit();
}

$alternatif = array();
$nama_alternatif = array();
$ambil = $koneksi->query("SELECT * FROM alternatif ORDER BY kode_alternatif ASC");
while($tiap = $ambil->fetch_assoc()) {
    $nama_alternatif[$tiap['kode_alternatif']] = $tiap['nama_alternatif'];
    $alternatif[] = $tiap;
}

$kriteria = array();
$atribut_kriteria = array();
$bobot_kriteria = array();
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while($tiap = $ambil->fetch_assoc()) {
    $atribut_kriteria[$tiap['kode_kriteria']] = $tiap['atribut_kriteria'];
    $bobot_kriteria[$tiap['kode_kriteria']] = $tiap['bobot_kriteria'];
    $kriteria[] = $tiap;
}

$nilai = array();
$ambil = $koneksi->query("SELECT * FROM nilai LEFT JOIN subkriteria ON nilai.id_subkriteria=subkriteria.id_subkriteria ORDER BY id_nilai ASC");
while($tiap = $ambil->fetch_assoc()) {
    $nilai[] = $tiap;
}

$analisa = array();
foreach ($alternatif as $key => $peralternatif) {
    $kode_alternatif = $peralternatif['kode_alternatif'];
    foreach($kriteria as $key => $perkriteria) {
        $kode_kriteria = $perkriteria['kode_kriteria'];
        foreach($nilai as $key => $pernilai) {
            if($pernilai['kode_alternatif'] == $kode_alternatif && $pernilai['kode_kriteria'] == $kode_kriteria) {
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .kop-surat {
        display: flex;
        align-items: center;
        border-bottom: 2px solid black;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .kop-surat img {
        width: 100px;
        height: auto;
        margin-right: 15px;
    }

    .kop-surat .info {
        font-family: Arial, sans-serif;
        text-align: center;
        flex-grow: 1;
        letter-spacing: 1px;
    }

    .kop-surat h2 {
        margin: 0;
        font-size: 20px;
    }

    .kop-surat p {
        margin: 2px 0;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    table th {
        background-color: #f2f2f2;
    }

    .tanda-tangan {
        margin-top: 50px;
        text-align: right;
    }

    .tanda-tangan p {
        margin: 0;
    }

    .content {
        font-size: 14px;
        text-align: justify;
        line-height: 1.8;
    }

    .arabic {
        font-size: 16px;
        font-weight: bold;
        display: block;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="image/Logo_kop.jpg" alt="Logo LAZ Al-Muthi'in">
        <div class="info">
            <h2>LEMBAGA AMIL ZAKAT AL-MUTHI'IN</h2>
            <p>Izin Kementerian Agama Daerah Istimewa Yogyakarta Nomor: 116 Tahun 2023</p>
            <p>Jalan Cendrawasih No 053 A Maguwo Banguntapan Bantul Yogyakarta 55198</p>
            <p>Telp 085174184090</p>
        </div>
    </div>

    <p class="content">
        <span class="arabic">السلام عليكم ورحمة الله وبركاته</span>
        <br>
        Dengan ini kami sampaikan hasil seleksi calon penerima program pemberdayaan ekonomi LAZ Al-Muthi'in.
        Berdasarkan analisis data, berikut adalah daftar penerima yang mendapatkan rekomendasi nilai tertinggi.
        Semoga laporan ini dapat memberikan gambaran yang jelas dan menjadi acuan dalam pengambilan keputusan.
        <br><br>
        <span class="arabic">والسلام عليكم ورحمة الله وبركاته</span>
    </p>

    <h3>Perangkingan</h3>
    <table>
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
                <td><?php echo $rangking; ?></td>
                <td><?php echo $nama_alternatif[$kode_alternatif]; ?></td>
                <td><?php echo number_format($totalnilai, 2); ?></td>
            </tr>
            <?php $rangking++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Sleman, <?php echo date('d-m-Y'); ?></p>
        <p><strong>Manager</strong></p>
        <br><br>
        <p>_________________________</p>
    </div>
</body>

<script>
window.print();
</script>

</html>