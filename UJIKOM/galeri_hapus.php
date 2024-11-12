<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user']['id_user'])) {
    die("Anda harus login terlebih dahulu.");
}

$id_user_login = $_SESSION['user']['id_user']; // ID pengguna yang login

// Cek apakah ada ID foto yang diterima untuk dihapus
if (isset($_POST['selected_photos'])) {
    $selected_photos = $_POST['selected_photos'];

    // Proses penghapusan foto yang dipilih
    foreach ($selected_photos as $id_foto) {
        // Query untuk mendapatkan ID user yang mengunggah foto
        $query = mysqli_query($koneksi, "SELECT id_user FROM foto WHERE id_foto = $id_foto");
        $foto = mysqli_fetch_assoc($query);

        // Cek apakah foto milik pengguna yang login
        if ($foto && $foto['id_user'] == $id_user_login) {
            // Hapus foto dari database
            $deleteQuery = mysqli_query($koneksi, "DELETE FROM foto WHERE id_foto = $id_foto");

            // Hapus file gambar dari server
            if ($deleteQuery) {
                $filePath = "gambar/$id_foto.jpg"; // Ubah jika ekstensi file berbeda
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
}

header("Location: ?page=galeri");
exit();
?>
