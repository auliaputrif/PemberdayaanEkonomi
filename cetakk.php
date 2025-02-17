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
while($tiap = $ambil->fetch_assoc())
{
    $nama_alternatif[$tiap['kode_alternatif']] = $tiap['nama_alternatif'];
    $alternatif[]= $tiap;
}

$kriteria = array();
$atribut_kriteria = array();
$bobot_kriteria = array();
$ambil = $koneksi->query("SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while($tiap = $ambil->fetch_assoc())
{
    $atribut_kriteria[$tiap['kode_kriteria']] = $tiap['atribut_kriteria'];
    $bobot_kriteria[$tiap['kode_kriteria']] = $tiap['bobot_kriteria'];
    $kriteria[]= $tiap;
}

$nilai = array();
$ambil = $koneksi->query("SELECT * FROM nilai LEFT JOIN subkriteria ON nilai.id_subkriteria=subkriteria.id_subkriteria
    ORDER BY id_nilai ASC");
while($tiap = $ambil->fetch_assoc())
{
    $nilai[]= $tiap;
}

//echo "<pre>";
//print_r ($alternatif);
//print_r ($kriteria);
//print_r ($nilai);
//echo "</pre>";

$analisa = array();
foreach ($alternatif as $key => $peralternatif) {
    $kode_alternatif = $peralternatif['kode_alternatif'];

    foreach($kriteria as $key => $perkriteria) {
        $kode_kriteria = $perkriteria['kode_kriteria'];

        foreach($nilai as $key => $pernilai) {
            if($pernilai['kode_alternatif']==$kode_alternatif && $pernilai['kode_kriteria']==$kode_kriteria) {
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
        if ($atribut_kriteria[$kode_kriteria]=="cost") {
            $normalisasi[$kode_alternatif][$kode_kriteria] = min($nilai_kriteria[$kode_kriteria])/ $nilai;
        } else {
           $normalisasi[$kode_alternatif][$kode_kriteria] = $nilai / max($nilai_kriteria[$kode_kriteria]);
       }
   }
}
$perangkingan = array();
foreach ($normalisasi as $kode_alternatif => $peralternatif) {

    $total = 0;
    foreach ($peralternatif as $kode_kriteria => $nilai_ternormalisasi) {
        $total+=$nilai_ternormalisasi * $bobot_kriteria[$kode_kriteria];
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
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <title>LAZ Al-Muthi'in</title>
    </head>

    <body>

        <!-- MAIN -->
        <main>
            <h3>Perangkingan<h3>
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
        </main>
        <!-- MAIN -->
        </section>
        <!-- NAVBAR -->
        <script src="js/script.js"></script>
    </body>

</html>


<script>
window.print();
</script>