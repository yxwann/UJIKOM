<?php
// mendapatkan ID foto yang dipilih dari parameter URL
$id = $_GET['id'];

// mendapatkan ID user yang sedang login dari session
$id_user_login = $_SESSION['user']['id_user'];

// mengambil data foto berdasarkan ID foto
$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE id_foto=$id");
$data = mysqli_fetch_array($query);

// memeriksa apakah foto ada dan apakah pemilik foto sesuai dengan ID user yang login
if ($data && $data['id_user'] == $id_user_login) {
    // Jika form telah disubmit (menggunakan method POST)
    if (isset($_POST['judul'])) {
        // Mendapatkan data yang diinputkan pengguna
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $id_album = $_POST['id_album'];
        $tanggal = $_POST['tanggal'];

        // Query untuk memperbarui data foto di database
        $query = mysqli_query($koneksi, "UPDATE foto SET judul='$judul', deskripsi='$deskripsi', id_album='$id_album', tanggal='$tanggal' WHERE id_foto=$id");

        // Menangani upload gambar baru jika ada
        $gambar = $_FILES['gambar'];
        if (!empty($gambar['name'])) {
            // Menyimpan nama gambar dan file gambar sementara
            $nama_gambar = $gambar['name'];
            $temp_gambar = $gambar['tmp_name'];

            // Memindahkan file gambar ke folder gambar dan memperbarui database
            if (move_uploaded_file($temp_gambar, 'gambar/' . $nama_gambar)) {
                $query = mysqli_query($koneksi, "UPDATE foto SET gambar='$nama_gambar' WHERE id_foto=$id");
            }
        }

        // Mengecek hasil query, apakah berhasil atau tidak
        if ($query) {
            echo '<script>alert("Ubah Data Berhasil");</script>';
        } else {
            echo '<script>alert("Ubah Data Gagal");</script>';
        }
    }
} else {
    // Jika foto tidak ditemukan atau user tidak memiliki izin untuk mengedit foto
    echo '<script>alert("Anda tidak memiliki izin untuk mengedit foto ini."); location.href="?page=galeri";</script>';
}
?>

<div class="container-fluid px-4 custom-bg">
    <h1 class="mt-4 text-center">Edit Galeri Foto</h1>
    <a href="?page=galeri" class="btn btn-danger mb-3">Kembali</a>
    <form method="post" enctype="multipart/form-data" class="form-upload">
        <div class="form-card">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Foto</label>
                <input type="text" name="judul" id="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" class="form-control" placeholder="Masukkan judul foto" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Foto</label>
                <input type="text" name="deskripsi" id="deskripsi" value="<?php echo htmlspecialchars($data['deskripsi']); ?>" class="form-control" placeholder="Masukkan deskripsi foto" required>
            </div>
            <div class="mb-3">
                <label for="id_album" class="form-label">Pilih Album</label>
                <select name="id_album" id="id_album" class="form-select">
                    <?php
                    $al = mysqli_query($koneksi, "SELECT * FROM album");
                    while ($album = mysqli_fetch_array($al)) {
                    ?>
                        <option <?php if ($data['id_album'] == $album['id_album']) echo 'selected'; ?> value="<?php echo $album['id_album']; ?>">
                            <?php echo htmlspecialchars($album['nama_album']); ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Foto</label>
                <input type="date" name="tanggal" id="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <div class="mt-2">
                    <a href="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" target="_blank">
                        <img src="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" alt="gambar" class="img-thumbnail" width="200">
                    </a>
                    <small class="text-danger">*Jika tidak diganti, kosongkan saja</small>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>
</div>

<style>
    /* Latar belakang halaman */
    .custom-bg {
        background: linear-gradient(135deg, #1a1a1a, #2e2e2e);
        padding: 30px;
        border-radius: 10px;
        color: #ffffff;
    }

    /* Gaya form card */
    .form-card {
        background: #2c2c2c;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s, box-shadow 0.3s;
    }



    /* Label form */
    .form-label {
        font-weight: bold;
        color: #ffc107; /* Warna kuning */
    }

    /* Input dan select */
    .form-control, .form-select {
        background-color: #343a40;
        color: #ffffff;
        border: 1px solid #6c757d;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background-color: #495057;
        border-color: #ffc107; /* Warna kuning saat fokus */
        box-shadow: 0 0 5px rgba(255, 204, 0, 0.3);
    }

    /* Tombol utama */
    .btn-primary {
        background-color: #ffc107; /* Warna kuning */
        border: none;
        color: #1a1a1a;
        transition: background 0.3s, transform 0.2s;
    }


    /* Tombol sekunder */
    .btn-secondary {
        background-color: #444;
        border: none;
        color: #ffffff;
        transition: background 0.3s, transform 0.2s;
    }

    /* Gambar thumbnail */
    .img-thumbnail {
        border: 1px solid #6c757d;
        border-radius: 5px;
    }

    /* Judul halaman */
    h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }
</style>
