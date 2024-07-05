<?php 

session_start();

// Check if user is logged in
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu');
        document.location.href = 'login.php';
        </script>";
    exit;
}

// Check user access level
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 2) {
    echo "<script>
        alert('Anda tidak memiliki hak akses');
        document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

// Page title
$title = 'Daftar Barang';

// Include header
include 'layout/header2.php';

if (isset($_POST['filter'])) {
  $tgl_awal = strip_tags($_POST['tgl_awal'] . "00:00:00");
  $tgl_akhir = strip_tags($_POST['tgl_akhir'] . "23:59:59");

  //query data
  $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");

} else {
  //query tampil seluruh data
  $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC");
}

// Database query to fetch barang data
$barang = select("SELECT * FROM barang ORDER BY id_barang ASC");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

        <!-- /.row -->
        <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Barang</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <a href="tambah-barang.php" class="btn btn-primary mb-2"><i class="fas fa-plus"></i>Tambah Barang</a>
              <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-search">Filter Data</i></button>
                <table id="example2" class="table table-bordered table-hover">
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
                    <td><?= $item['nama']; ?></td>
                    <td><?= $item['jumlah']; ?></td>
                    <td>Rp. <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td class="text-center">
                        <img src="barcode.php?codetype=Code128&size=15&text=<?= $item['barcode']; ?>& print=true" alt="barcode" />
                    </td>
                    <td><?= date("d/m/Y | H:i:s", strtotime($item['tanggal'])); ?></td>
                    <td width="20%" class="text-center">
                        <a href="ubah-barang.php?id_barang=<?= $item['id_barang']; ?>" class="btn btn-success">Ubah</a>
                        <a href="hapus-barang.php?id_barang=<?= $item['id_barang']; ?>" class="btn btn-danger" onclick="return confirm('Yakin data barang akan dihapus')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</table>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
  <!-- Modal Filter -->
   <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModallabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="exampleModallabel"><i class="fas fa-search"></i>Filter Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form action="" method="post">
          <div class="form-group">
            <label for="tgl_awal">Tanggal Awal</label>
            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
          </div>
          <div class="form-group">
            <label for="tgl_akhir">Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-success btn-sm" name="filter">Submit</button>
          </div>
         </form>
      </div>
    </div>
   </div>

  <?php include 'layout/footer2.php'; ?>