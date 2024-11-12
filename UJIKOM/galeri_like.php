<?php
// Mendapatkan ID foto yang dikirimkan melalui URL
$id_foto = $_GET['id'];  
// Mendapatkan ID pengguna yang sedang login dari session
$id_user = $_SESSION['user']['id_user']; 
// Mendapatkan tanggal saat ini dalam format Y/m/d
$tanggal = date("Y/m/d");

// Memeriksa apakah pengguna sudah pernah memberikan like pada foto ini
$check_query = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE id_foto = '$id_foto' AND id_user = '$id_user'");
$is_liked = mysqli_num_rows($check_query) > 0;  // Mengecek apakah sudah ada record untuk like oleh user ini

// Jika sudah pernah like (is_liked = true), maka lakukan proses Dislike
if ($is_liked) {
    // Menghapus like dari database (Dislike)
    $query = mysqli_query($koneksi, "DELETE FROM likefoto WHERE id_foto = '$id_foto' AND id_user = '$id_user'");
    if ($query) {
        echo '<script>alert("Dislike Foto Berhasil"); location.href="?page=galeri"; </script>';
    } else {
        echo '<script>alert("Dislike Foto Gagal");</script>';
    }
} else {
    // Jika belum pernah like (is_liked = false), maka lakukan proses Like
    $query = mysqli_query($koneksi, "INSERT INTO likefoto (id_foto, id_user, tanggal) VALUES ('$id_foto', '$id_user', '$tanggal')");
    if ($query) {
        echo '<script>alert("Like Foto Berhasil"); location.href="?page=galeri"; </script>';
    } else {
        echo '<script>alert("Like Foto Gagal");</script>';
    }
}
?>
