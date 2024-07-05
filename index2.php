<?php 
session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('login dulu');
        document.location.href = 'login.php';
        </script>";
    exit;
}

// membatasi halaman sesuai user login
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 2) {
    echo "<script>
        alert('Anda tidak memiliki hak akses');
        document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = 'Daftar Barang';

include 'layout/header.php';

$barang = select("SELECT * FROM barang ORDER BY id_barang ASC");
?>

<div class="container mt-5">
    <h1>Data Barang</h1>
    <hr>

    <a href="tambah-barang.php" class="btn btn-primary mb-1"><i class="fa-solid fa-circle-plus"></i>Tambah</a>

    <table class="table table-bordered table-striped mt-3" id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Barcode</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($barang as $item) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($item['nama']); ?></td>
                <td><?= htmlspecialchars($item['jumlah']); ?></td>
                <td>Rp. <?= number_format($item['harga']); ?></td>
                <td>
                    <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= htmlspecialchars($item['barcode']); ?>&print=true" />
                </td>
                <td><?= date("d/m/Y | H:i:s", strtotime($item['tanggal'])); ?></td>
                <td width="20%" class="text-center">
                    <a href="ubah-barang.php?id_barang=<?= $item['id_barang']; ?>" class="btn btn-success">Ubah</a>
                    <a href="hapus-barang.php?id_barang=<?= $item['id_barang']; ?>" class="btn btn-danger" onclick="return confirm('Yakin data barang akan di hapus')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'layout/footer.php'; ?>
