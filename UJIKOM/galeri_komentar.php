<?php

// Ambil ID foto dari URL
$id = $_GET['id']; // Mengambil ID foto dari URL untuk digunakan dalam query

// Query untuk mengambil data foto berdasarkan ID
$queryFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE id_foto = $id");
$data = mysqli_fetch_array($queryFoto); 
?>


<div class="container-fluid px-4 photo-page-bg">
    <h1 class="mt-4 text-center display-6 page-title">Detail Galeri Foto</h1>
    <ol class="breadcrumb mb-4 justify-content-center">
        <li class="breadcrumb-item"><a href="?page=galeri">Galeri Foto</a></li>
    </ol>

    <div class="text-center mb-4">
        <a href="?page=galeri" class="btn btn-danger rounded-pill shadow-sm">Kembali</a>
    </div>

    <!-- Menampilkan detail foto -->
    <div class="photo-detail shadow p-4 mb-5 rounded">
        <div class="row">
            <div class="col-md-4 text-center">
                
                <a href="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" target="_blank">
                    <img src="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" alt="gambar" class="img-fluid rounded shadow-lg animated-img">
                </a>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless">
                    
                    <tr>
                        <th>Judul</th>
                        <td><?php echo htmlspecialchars($data['judul']); ?></td>
                    </tr>
                    
                    <tr>
                        <th>Deskripsi</th>
                        <td><?php echo htmlspecialchars($data['deskripsi']); ?></td>
                    </tr>
                    
                    <tr>
                        <th>Album</th>
                        <td>
                            <select name="id_album" disabled class="form-select">
                                <?php
                                // Query untuk mengambil semua album
                                $al = mysqli_query($koneksi, "SELECT * FROM album");
                                while ($album = mysqli_fetch_array($al)) {
                                ?>
                                    <!-- Menampilkan album yang sesuai dengan foto -->
                                    <option <?php if ($data['id_album'] == $album['id_album']) echo 'selected'; ?>
                                        value="<?php echo $album['id_album']; ?>">
                                        <?php echo htmlspecialchars($album['nama_album']); ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Tanggal</th>
                        <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

   
    <h2 class="text-center mb-4 display-6">Komentar Foto</h2>
    <div class="comments-section mb-4">
        <?php
        // Query untuk mengambil komentar yang ada pada foto tersebut
        $queryKomentar = mysqli_query($koneksi, "SELECT komentar.*, user.nama_lengkap FROM komentar LEFT JOIN user ON user.id_user = komentar.id_user WHERE id_foto = $id ORDER BY tanggal DESC");
        while ($komentar = mysqli_fetch_array($queryKomentar)) {
        ?>
            <!-- Menampilkan komentar dengan informasi dan tanggal -->
            <div class="comment-card card mb-3 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <strong><?php echo htmlspecialchars($komentar['nama_lengkap']); ?></strong>
                    <small><?php echo htmlspecialchars($komentar['tanggal']); ?></small>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($komentar['komentar'])); ?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Form untuk menambahkan komentar baru dengan validasi -->
    <form method="post" class="add-comment-form shadow-sm p-4 bg-light rounded" onsubmit="return validateComment()">
        <h5 class="mb-3">Tambah Komentar Baru</h5>
        <textarea name="komentar" id="komentar" rows="5" class="form-control mb-3" placeholder="Tuliskan komentar Anda..."></textarea>
        <button type="submit" class="btn btn-primary rounded-pill shadow-lg animated-btn">Simpan</button>
    </form>

    <form method="post" class="add-comment-form shadow-sm p-4 bg-light rounded" onsubmit="return validateComment()">
        <h5 class="mb-3">Tuliskan saran anda</h5>
        <textarea name="komentar" id="komentar" rows="5" class="form-control mb-3" placeholder="Tuliskan saran anda..."></textarea>
        <button type="submit" class="btn btn-primary rounded-pill shadow-lg animated-btn">Simpan</button>
    </form>

    <?php
    // Jika form komentar di-submit
    if (isset($_POST['komentar']) && !empty(trim($_POST['komentar']))) {
        $komentar = $_POST['komentar']; // Menyimpan komentar yang dimasukkan pengguna
        $tanggal = date("Y-m-d"); // Mendapatkan tanggal saat ini
        $id_user = $_SESSION['user']['id_user']; // Mengambil ID pengguna yang sedang login

        // Query untuk menyimpan komentar ke dalam database
        $queryInsert = mysqli_query($koneksi, "INSERT INTO komentar (id_foto, id_user, komentar, tanggal) VALUES ('$id', '$id_user', '$komentar', '$tanggal')");

        if ($queryInsert) {
            echo '<script>alert("Tambah Komentar Berhasil"); window.location.href="?page=galeri_komentar&id='.$id.'";</script>';
        } else {
            echo '<script>alert("Tambah Komentar Gagal");</script>';
        }
    } elseif (isset($_POST['komentar'])) {
    
        echo '<script>alert("Komentar tidak boleh kosong");</script>';
    }
    ?>
</div>

<script>
    function validateComment() {
        // Mengambil komentar dari textarea
        const komentar = document.getElementById("komentar").value.trim();
        
        
        if (komentar === "") {
            alert("Komentar tidak boleh kosong.");
            return false; 
        }
        return true; 
    }
</script>


<style>
    /* Background */
    .photo-page-bg {
        background: radial-gradient(circle, #1a1a1a, #333333);
        padding: 30px;
        min-height: 100vh;
        color: #f5f5dc;
        font-family: 'Courier New', Courier, monospace;
    }

    /* Page Title */
    .page-title {
        font-family: 'Courier New', Courier, monospace;
        color: #ffcc00;
        margin-bottom: 20px;
        text-shadow: 2px 2px #4d4d4d;
    }

    /* Photo Detail Card */
    .photo-detail {
        background: #2b2b2b;
        border: 2px solid #ffcc00;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Image Animation */
    .animated-img {
        transition: transform 0.3s ease;
        border-radius: 8px;
        border: 2px solid #ffcc00;
    }

    /* Comment Card */
    .comment-card {
        background: #1a1a1a;
        color: #f5f5dc;
        border: 1px solid #ffcc00;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
    }


    /* Comments Section */
    .comments-section {
        max-width: 800px;
        margin: 0 auto;
    }

    /* Table Styling */
    .table th {
        width: 150px;
        color: #ffcc00;
        font-weight: bold;
    }

    .table td {
        color: #f5f5dc;
    }

    /* Form Styling */
    .add-comment-form {
        max-width: 800px;
        margin: 20px auto;
        background: #2b2b2b;
        border: 1px solid #ffcc00;
    }

    /* Button Animation */
    .animated-btn {
        transition: background-color 0.3s ease, transform 0.2s ease;
        background: #4d4d4d;
        color: #f5f5dc;
        border: none;
    }


    /* Custom Scrollbar for Comment Section */
    .comments-section {
        overflow-y: auto;
        max-height: 50vh;
        padding-right: 5px;
    }

    .comments-section::-webkit-scrollbar {
        width: 8px;
    }

    .comments-section::-webkit-scrollbar-thumb {
        background: #ffcc00;
        border-radius: 4px;
    }

    /* Breadcrumb */
    .breadcrumb {
        background-color: transparent;
        font-weight: 500;
        color: #f5f5dc;
    }

    .breadcrumb-item a {
        color: #ffcc00;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #f5f5dc;
    }

    /* Overall Spacing */
    .container-fluid {
        padding: 50px;
    }
</style>
