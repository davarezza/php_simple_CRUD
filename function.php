<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah($data) {
    global $conn;

    // ambil data tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $nis = htmlspecialchars($data["nis"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

        // query insert data
        $query = "INSERT INTO siswa
        VALUES
       ('', '$nama', '$nis', '$email', '$jurusan', '$gambar')
     ";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}


function upload() {
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah ada gambar diupload / tidak
    if( $error === 4 ) {
        echo "<script>alert('pilih gambar terlebih dahulu!')</script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>alert('gambar yang anda upload tidak memenuhi kriteria')</script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > 2000000 ) {
        echo "<script>alert('ukuran gambar terlalu besar')</script>";
        return false;
    }

    // lolos pengecekan, upload gambar
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= $ekstensiGambar; 
    move_uploaded_file($tmpName, 'thumb/' . $namaFileBaru);

    return $namaFileBaru;
}


function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM siswa WHERE id  = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data) {
    global $conn;

    $id = $data["id"];
    // ambil data tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $nis = htmlspecialchars($data["nis"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru / tidak
    if( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

        // query update data
        $query = "UPDATE siswa SET 
                    nama = '$nama',
                    nis = '$nis',
                    email = '$email',
                    jurusan = '$jurusan',
                    gambar = '$gambar'
                   WHERE id = $id
                ";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM siswa
                WHERE
               nama LIKE '%$keyword%' OR
               nis LIKE '%$keyword%' OR
               email LIKE '%$keyword%' OR
               jurusan LIKE '%$keyword%'
               ";
        return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
            alert('username sudah terdaftar! gunakan username yang lain!');
        </script>";
        return false;
    }

    // cek konfirmasi password
    if ( $password !== $password2 ) {
        echo "<script>
            alert('konfirmasi password tidak sesuai')
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

?>