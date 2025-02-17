<?php
include 'koneksi.php';

// Periksa session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda harus login')</script>";
    echo "<script>location='index.php'</script>";
    exit();
}

// Ambil data Alternatif
$alternatif = [];
$nama_alternatif = [];
$ambil = $koneksi->query("SELECT * FROM alternatif ORDER BY kode_alternatif ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $nama_alternatif[$tiap['kode_alternatif']] = $tiap['nama_alternatif'];
    $alternatif[] = $tiap;
}

// Ambil data Kriteria
$kriteria = [];
$atribut_kriteria = [];
$bobot_kriteria = [];
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $atribut_kriteria[$tiap['kode_kriteria']] = $tiap['atribut_kriteria'];
    $bobot_kriteria[$tiap['kode_kriteria']] = $tiap['bobot_kriteria'];
    $kriteria[] = $tiap;
}

// Ambil data Nilai
$nilai = [];
$ambil = $koneksi->query("SELECT * FROM nilai 
    LEFT JOIN subkriteria ON nilai.id_subkriteria = subkriteria.id_subkriteria 
    ORDER BY id_nilai ASC");
while ($tiap = $ambil->fetch_assoc()) {
    $nilai[] = $tiap;
}

// Proses Analisa
$analisa = [];
foreach ($alternatif as $peralternatif) {
    $kode_alternatif = $peralternatif['kode_alternatif'];
    foreach ($kriteria as $perkriteria) {
        $kode_kriteria = $perkriteria['kode_kriteria'];
        foreach ($nilai as $pernilai) {
            if ($pernilai['kode_alternatif'] == $kode_alternatif && $pernilai['kode_kriteria'] == $kode_kriteria) {
                $analisa[$kode_alternatif][$kode_kriteria] = $pernilai['nilai_subkriteria'];
            }
        }
    }
}

// Normalisasi
$nilai_kriteria = [];
foreach ($analisa as $kode_alternatif => $peralternatif) {
    foreach ($peralternatif as $kode_kriteria => $nilai) {
        $nilai_kriteria[$kode_kriteria][] = $nilai;
    }
}

$normalisasi = [];
foreach ($analisa as $kode_alternatif => $peralternatif) {
    foreach ($peralternatif as $kode_kriteria => $nilai) {
        if ($atribut_kriteria[$kode_kriteria] == "cost") {
            $normalisasi[$kode_alternatif][$kode_kriteria] = min($nilai_kriteria[$kode_kriteria]) / $nilai;
        } else {
            $normalisasi[$kode_alternatif][$kode_kriteria] = $nilai / max($nilai_kriteria[$kode_kriteria]);
        }
    }
}

// Perangkingan
$perangkingan = [];
foreach ($normalisasi as $kode_alternatif => $peralternatif) {
    $total = 0;
    foreach ($peralternatif as $kode_kriteria => $nilai_ternormalisasi) {
        $total += $nilai_ternormalisasi * $bobot_kriteria[$kode_kriteria];
    }
    $perangkingan[$kode_alternatif] = $total;
}

arsort($perangkingan);

// Header untuk Ekspor Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=perangkingan_" . date('Y-m-d') . ".xls");

// Tampilkan Data dalam Bentuk Tabel
echo "<table border='1'>
<tr>
    <th>Rangking</th>
    <th>Alternatif</th>
    <th>Total Nilai</th>
</tr>";

$rangking = 1;
foreach ($perangkingan as $kode_alternatif => $totalnilai) {
    echo "<tr>
        <td>{$rangking}</td>
        <td>" . (isset($nama_alternatif[$kode_alternatif]) ? $nama_alternatif[$kode_alternatif] : 'Tidak Diketahui') . "</td>
        <td>" . number_format($totalnilai, 4) . "</td>
    </tr>";
    $rangking++;
}
echo "</table>";
?>