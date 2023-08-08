<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'function.php';

// ambil data di url
$id = $_GET["id"];

// query data siswa berdasarkan id
$sis = query("SELECT * FROM siswa WHERE id = $id")[0];


// cek tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // cek data berhasil diubah atau gagal
    if( ubah($_POST) > 0 ) {
        echo "
        <script>
            alert('data berhasil diubah');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal diubah');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
</head>
<body>
    <h1>Ubah Data Siswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $sis["id"]; ?>">  
        <input type="hidden" name="gambarLama" value="<?= $sis["gambar"]; ?>">  
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required value="<?= $sis["nama"]; ?>">
            </li>
            <li>
                <label for="nis">NIS : </label>
                <input type="text" name="nis" id="nis" required value="<?= $sis["nis"]; ?>">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" required value="<?= $sis["email"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $sis["jurusan"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <img src="thumb/<?= $sis['gambar']; ?>" alt="" width="50"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data!</button>
            </li>
        </ul>

    </form>
</body>
</html>