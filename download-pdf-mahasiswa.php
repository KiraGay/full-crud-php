<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
        </script>";
    exit;
}

if ($_SESSION["level"] != 1 && $_SESSION["level"] != 3) {
    echo "<script>
        alert('Anda tidak memiliki hak akses');
        document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

require __DIR__.'/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

// Ambil data dari database
$data_barang = select("SELECT * FROM mahasiswa");

// Cek apakah data berhasil diambil
if (!$data_barang) {
    echo "<script>
        alert('Gagal mengambil data dari database');
        document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$content = '<style type="text/css">
    .gambar {
        width: 50px;
    }
</style>';

$content .= '<page>
    <table border="1" align="center">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Foto</th>
        </tr>';

$no = 1;
foreach ($data_barang as $barang) {
    $content .= '
        <tr>
            <td>'.$no++.'</td>
            <td>'.$barang['nama'].'</td>
            <td>'.$barang['prodi'].'</td>
            <td>'.$barang['jk'].'</td>
            <td>'.$barang['telepon'].'</td>
            <td>'.$barang['email'].'</td>
            <td><img src="assets/img/'.$barang['foto'].'" class="gambar"></td>
        </tr>';
}

$content .= '</table>
    </page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output('Laporan-mahasiswa.pdf'); 
?>
