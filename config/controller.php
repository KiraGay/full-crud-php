<?php 

include 'database.php';

// Fungsi menampilkan(read)
function select($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$data_barang = select("SELECT * FROM barang");

// Fungsi menambahkan data barang(create)
function create_barang($post)
{
    global $db;

    $nama = mysqli_real_escape_string($db, $post['nama']);
    $jumlah = mysqli_real_escape_string($db, $post['jumlah']);
    $harga = mysqli_real_escape_string($db, $post['harga']);
    $barcode = rand(100000, 999999);

    // query tambah data
    $query = "INSERT INTO barang VALUES(null, '$nama','$jumlah','$harga', '$barcode', CURRENT_TIMESTAMP())";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi mengubah data barang(update)
function update_barang($post)
{
    global $db;

    $id_barang = mysqli_real_escape_string($db, $post['id_barang']);
    $nama = mysqli_real_escape_string($db, $post['nama']);
    $jumlah = mysqli_real_escape_string($db, $post['jumlah']);
    $harga = mysqli_real_escape_string($db, $post['harga']);

    // query ubah data
    $query = "UPDATE barang SET nama = '$nama', jumlah = '$jumlah', harga = '$harga' WHERE id_barang = $id_barang";
    
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menghapus data barang(delete)
function delete_barang($id_barang)
{
    global $db;

    $id_barang = mysqli_real_escape_string($db, $id_barang);

    $query = "DELETE FROM barang WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menambahkan data mahasiswa(create)
function create_mahasiswa($post)
{
    global $db;

    $nama = strip_tags(mysqli_real_escape_string($db, $post['nama']));
    $prodi = strip_tags(mysqli_real_escape_string($db, $post['prodi']));
    $jk = strip_tags(mysqli_real_escape_string($db, $post['jk']));
    $telepon = strip_tags(mysqli_real_escape_string($db, $post['telepon']));
    $alamat = $post['alamat'];
    $email = strip_tags(mysqli_real_escape_string($db, $post['email']));
    $foto = upload_file();

    // check upload foto
    if (!$foto) {
        return false;
    }

    // query tambah data
    $query = "INSERT INTO mahasiswa VALUES(null, '$nama','$prodi','$jk', '$telepon', '$alamat', '$email')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi mengupload file
function upload_file()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // check file yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    // check format/extensi file
    if (!in_array($extensifile, $extensifileValid)) {
        // pesan gagal
        echo "<script>
            alert('Format File Tidak Valid');
            document.location.href = 'tambah-mahasiswa.php';
            </script>";
        die();
    }

    // check ukuran file 2 mb
    if ($ukuranFile > 2048000) {
        // pesan gagal
        echo "<script>
            alert('Ukuran File Terlalu Besar');
            document.location.href = 'tambah-mahasiswa.php';
            </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // pindahkan ke folder local
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

// Fungsi mengubah data mahasiswa(update)
function update_mahasiswa($post)
{
    global $db;

    $id_mahasiswa = strip_tags(mysqli_real_escape_string($db, $post['id_mahasiswa']));
    $nama = strip_tags(mysqli_real_escape_string($db, $post['nama']));
    $prodi = strip_tags(mysqli_real_escape_string($db, $post['prodi']));
    $jk = strip_tags(mysqli_real_escape_string($db, $post['jk']));
    $telepon = strip_tags(mysqli_real_escape_string($db, $post['telepon']));
    $alamat = strip_tags(mysqli_real_escape_string($db, $post['alamat']));
    $email = strip_tags(mysqli_real_escape_string($db, $post['email']));

    // check upload foto baru atau tidak
    if ($_FILES['foto']['error'] == 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload_file();
    }

    // query ubah data
    $query = "UPDATE mahasiswa SET nama = '$nama', prodi = '$prodi', jk = '$jk', telepon = '$telepon', alamat = '$alamat', email = '$email' WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menghapus data mahasiswa(delete)
function delete_mahasiswa($id_mahasiswa)
{
    global $db;

    $id_mahasiswa = mysqli_real_escape_string($db, $id_mahasiswa);

    // ambil foto sesuai data yang dipilih
    $foto = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
    unlink("assets/img/" . $foto['foto']);

    // query hapus data mahasiswa
    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menambahkan akun(create)
function create_akun($post)
{
    global $db;

    $nama = strip_tags(mysqli_real_escape_string($db, $post['nama']));
    $username = strip_tags(mysqli_real_escape_string($db, $post['username']));
    $email = strip_tags(mysqli_real_escape_string($db, $post['email']));
    $password = strip_tags(mysqli_real_escape_string($db, $post['password']));
    $level = strip_tags(mysqli_real_escape_string($db, $post['level']));

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // query tambah data
    $query = "INSERT INTO akun VALUES(null, '$nama', '$username', '$email', '$password', '$level')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi menghapus akun(delete)
function delete_akun($id_akun)
{
    global $db;

    $id_akun = mysqli_real_escape_string($db, $id_akun);

    // query hapus data akun
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi mengubah akun(update)
function update_akun($post)
{
    global $db;

    $id_akun = strip_tags(mysqli_real_escape_string($db, $post['id_akun']));
    $nama = strip_tags(mysqli_real_escape_string($db, $post['nama']));
    $username = strip_tags(mysqli_real_escape_string($db, $post['username']));
    $email = strip_tags(mysqli_real_escape_string($db, $post['email']));
    $password = strip_tags(mysqli_real_escape_string($db, $post['password']));
    $level = strip_tags(mysqli_real_escape_string($db, $post['level']));

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // query ubah data
    $query = "UPDATE akun SET nama = '$nama', username = '$username', email = '$email', password = '$password', level = '$level' WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
