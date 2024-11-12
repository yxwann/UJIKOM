<!DOCTYPE html>
<html lang="id">
<body>

    <?php
    // Mengambil jumlah album, foto, komentar, dan like dari database
    $totalAlbum = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM album"));
    $totalFoto = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM foto"));
    $totalKomentar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM komentar"));
    $totalLike = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likefoto"));
    ?>

    <div class="container-fluid px-4 custom-bg">
        <h1 class="mt-4 text-center page-title">WELCOME</h1>
        <br><br>

        <!-- Menampilkan data dalam bentuk kartu -->
        <div class="row text-center mb-5">
            <!-- Kartu Album -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow-lg bg-dark text-white mb-4 h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-folder fa-2x mb-3"></i>
                        <h5><?php echo $totalAlbum ?> Total Album</h5>
                        <p class="small">Jumlah album yang telah Anda buat.</p>
                    </div>
                </div>
            </div>
            <!-- Akhir Kartu Album -->

            <!-- Kartu Foto -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow-lg bg-dark text-white mb-4 h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-camera fa-2x mb-3"></i>
                        <h5><?php echo $totalFoto ?> Total Foto</h5>
                        <p class="small">Jumlah foto yang telah Anda unggah ke dalam album.</p>
                    </div>
                </div>
            </div>
            <!-- Akhir Kartu Foto -->

            <!-- Kartu Komentar -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow-lg bg-dark text-white mb-4 h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-comments fa-2x mb-3"></i>
                        <h5><?php echo $totalKomentar ?> Total Komentar</h5>
                        <p class="small">Jumlah komentar yang diterima oleh foto-foto Anda.</p>
                    </div>
                </div>
            </div>
            <!-- Akhir Kartu Komentar -->

            <!-- Kartu Like -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow-lg bg-dark text-white mb-4 h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-heart fa-2x mb-3"></i>
                        <h5><?php echo $totalLike ?> Total Like</h5>
                        <p class="small">Jumlah like yang diterima oleh foto-foto Anda.</p>
                    </div>
                </div>
            </div>
            <!-- Akhir Kartu Like -->
        </div>
        <!-- Akhir Baris Kartu -->

        <!-- Tombol untuk melihat semua foto -->
        <div class="text-center">
            <button class="btn btn-warning btn-lg" onclick="openPhotoModal()">
                Lihat Semua Foto
            </button>
        </div>
        <!-- Akhir Tombol Foto -->
    </div>

    <!-- Modal untuk menampilkan foto-foto -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Galeri Foto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                        // Query untuk mengambil foto-foto dari database
                        $foto_query = mysqli_query($koneksi, "SELECT * FROM foto");
                        if ($foto_query && mysqli_num_rows($foto_query) > 0) {
                            // Loop untuk menampilkan foto satu per satu
                            while ($foto = mysqli_fetch_array($foto_query)) {
                                echo '
                                <div class="col-md-4 mb-4">
                                    <a href="gambar/' . htmlspecialchars($foto['gambar'], ENT_QUOTES, 'UTF-8') . '" target="_blank">
                                        <img src="gambar/' . htmlspecialchars($foto['gambar'], ENT_QUOTES, 'UTF-8') . '" class="img-fluid rounded shadow-sm" alt="' . htmlspecialchars($foto['judul'], ENT_QUOTES, 'UTF-8') . '" style="height: 150px; object-fit: cover;">
                                    </a>
                                    <p class="text-white mt-2">' . htmlspecialchars($foto['judul'], ENT_QUOTES, 'UTF-8') . '</p>
                                </div>
                                ';
                            }
                        } else {
                            echo '<p class="text-muted">Tidak ada foto yang tersedia.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>

    <!-- Akhir Modal -->

    <style>
        .custom-bg {
            background: linear-gradient(135deg, #1a1a1a, #2e2e2e);
            min-height: 100vh;
            padding: 20px;
            color: #ffffff;
            animation: fadeInBackground 1s ease;
        }

        .page-title {
            font-family: 'Courier New', Courier, monospace;
            color: #ffc107;
            font-size: 2.5rem;
        }

        .card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            animation: slideIn 0.8s ease;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openPhotoModal() {
            var photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
            photoModal.show();
        }
    </script>

</body>

</html>