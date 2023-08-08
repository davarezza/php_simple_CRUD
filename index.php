<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}
require 'function.php';
// Ambil data dari tabel siswa(query)
$siswa = query("SELECT * FROM siswa ");

// tombol cari ditekan
if( isset($_POST["cari"]) ) {
    $siswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>

    <a href="logout.php">Log out</a>

    <h1>Daftar Siswa</h1>

    <a href="tambah.php">Tambah Data Siswa</a> <br> <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off" id="keyword">
        <button type="submit" name="cari" size="40" id="tombol-cari">Cari!</button> <br> <br>
    </form> <br>

    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach( $siswa as $row ) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a> |
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">Hapus</a>
            </td>
            <td><img src="thumb/<?= $row["gambar"]; ?>" width="70" alt=""></td>
            <td><?= $row["nis"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </div>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>