<?php
// Memeriksa apakah form telah disubmit (menggunakan method POST)
if (isset($_POST['judul'])) {
    // Mendapatkan data yang dikirimkan melalui form
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $id_album = $_POST['id_album'];
    $tanggal = $_POST['tanggal'];
    $id_user = $_SESSION['user']['id_user']; // Mendapatkan ID pengguna yang login dari session

    // Mengambil data file gambar yang diunggah
    $gambar = $_FILES['gambar'];
    $nama_gambar = $gambar['name']; // Nama file gambar
    $temp_gambar = $gambar['tmp_name']; // Lokasi sementara file gambar
    $file_ext = strtolower(pathinfo($nama_gambar, PATHINFO_EXTENSION));
    $file_type = mime_content_type($temp_gambar);

    // Hanya izinkan ekstensi file tertentu (JPG, JPEG, PNG, GIF)
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($file_ext, $allowed_extensions) && preg_match('/^image\/(jpeg|png|gif)$/', $file_type)) {
        // Memindahkan gambar dari lokasi sementara ke folder gambar jika format benar
        if (move_uploaded_file($temp_gambar, 'gambar/' . $nama_gambar)) {
            // Jika upload gambar berhasil, menyimpan data foto ke database
            $query = mysqli_query($koneksi, "INSERT INTO foto (judul, deskripsi, id_album, tanggal, gambar, id_user) VALUES ('$judul', '$deskripsi', '$id_album', '$tanggal', '$nama_gambar', '$id_user')");

            // Mengecek apakah query berhasil
            if ($query) {
                echo '<script>alert("Tambah Data Berhasil");</script>'; // Menampilkan pesan sukses
            } else {
                echo '<script>alert("Tambah Data Gagal");</script>'; // Menampilkan pesan gagal
            }
        } else {
            echo '<script>alert("Gagal mengunggah gambar.");</script>';
        }
    } else {
        // Menampilkan pesan error jika format file tidak sesuai
        echo '<script>alert("Hanya file gambar dengan format JPG, JPEG, PNG, atau GIF yang diperbolehkan.");</script>';
    }
}
?>



<div class="container-fluid px-4">
    <form method="post" enctype="multipart/form-data" class="photo-upload-form">
        <div class="form-card">
            <h1 class="text-center page-title">Tambah Foto</h1>
            <table class="table table-borderless">
                <tr>
                    <td><label for="judul">Judul:</label></td>
                    <td><input type="text" name="judul" id="judul" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="deskripsi">Deskripsi:</label></td>
                    <td><input type="text" name="deskripsi" id="deskripsi" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="id_album">Album:</label></td>
                    <td>
                        <select name="id_album" id="id_album" class="form-select form-control" required>
                            <?php
                            $al = mysqli_query($koneksi, "SELECT * FROM album");
                            while ($album = mysqli_fetch_array($al)) {
                            ?>
                                <option value="<?php echo $album['id_album']; ?>">
                                    <?php echo $album['nama_album']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal">Tanggal:</label></td>
                    <td><input type="date" name="tanggal" id="tanggal" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="gambar">Gambar:</label></td>
                    <td><input type="file" name="gambar" id="gambar" class="form-control" required></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <button type="reset" class="btn btn-secondary mt-3 ms-2">Riset</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<style>
    /* Container styling */
    .container-fluid {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #333, #555);
        color: #ffffff;
        padding: 20px;
    }

    /* Title styling */
    .page-title {
        color: #ffd700;
        font-family: 'Courier New', Courier, monospace;
        font-size: 2.5rem;
        text-shadow: 2px 2px 0px #000, -2px -2px 0px #000, 4px 4px 0px #ff8c00;
        margin-bottom: 20px;
    }

    /* Form card styling */
    .form-card {
        background: #1c1c1c;
        border-radius: 12px;
        padding: 30px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
        animation: fadeIn 0.6s ease;
        transition: transform 0.3s;
    }


    /* Table styling */
    .table td {
        vertical-align: middle;
    }

    /* Label styling */
    .table td label {
        font-weight: bold;
        color: #ffd700;
    }

    /* Input and Select styling */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #444;
        background-color: #333;
        color: #ffffff;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Button styling */
    .btn-primary {
        background: linear-gradient(45deg, #555, #333);
        border: none;
        color: #ffffff;
        transition: background 0.3s ease, transform 0.2s ease;
    }

 

    .btn-secondary {
        background: #444;
        border: none;
        color: #ffffff;
        transition: background 0.3s ease, transform 0.2s ease;
    }


    /* Warning button styling */
    .btn-warning {
        background: #ffc107;
        color: #2e2e2e;
        border: none;
        transition: background 0.3s ease, transform 0.2s ease;
    }

</style>
