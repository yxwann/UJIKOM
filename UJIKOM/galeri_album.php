<?php

// Pastikan parameter `id_album` ada dalam URL
if (isset($_GET['id_album'])) {
    $id_album = intval($_GET['id_album']);

    // Query untuk mendapatkan album berdasarkan `id_album`
    $queryAlbum = mysqli_query($koneksi, "SELECT * FROM album WHERE id_album = $id_album");
    $album = mysqli_fetch_array($queryAlbum);

    // Jika album tidak ditemukan, tampilkan pesan error
    if (!$album) {
        echo "<p class='text-danger'>Album tidak ditemukan.</p>";
    } else {
        echo "<h2 class='text-center text-warning'>Album: " . htmlspecialchars($album['nama_album']) . "</h2>";
        echo "<p class='text-center'>" . htmlspecialchars($album['deskripsi']) . "</p>";

        // Query untuk mendapatkan foto di dalam album
        $queryFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE id_album = $id_album");

        if (mysqli_num_rows($queryFoto) > 0) {
            echo "<div class='row'>";
            while ($foto = mysqli_fetch_array($queryFoto)) {
                // Pastikan path gambar sesuai dengan folder gambar
                $gambar_path = "gambar/" . htmlspecialchars($foto['gambar']); // Pastikan nama kolom 'gambar' sesuai
                ?>
                <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-lg bg-dark text-white h-100 card-hover">
                        <a href="<?php echo $gambar_path; ?>" target="_blank">
                            <img src="<?php echo $gambar_path; ?>" class="card-img-top" alt="gambar" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($foto['judul']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($foto['deskripsi']); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($foto['tanggal']); ?></small></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo "</div>";
        } else {
            echo "<p class='text-warning'>Tidak ada foto dalam album ini.</p>";
        }
    }
} else {
    echo "<p class='text-danger'>ID album tidak ditemukan.</p>";
}
?>

<div class="text-center mt-4">
    <a href="?page=album" class="btn btn-secondary">Kembali ke Album</a> <!-- Tombol kembali -->
</div>

<style>
    body {
        background-color: black; /* Latar belakang hitam */
    }
    .text-warning {
        color: #ffd700; /* Warna teks untuk pesan peringatan */
    }
    .text-danger {
        color: #ff0000; /* Warna teks untuk pesan error */
    }
    .btn-secondary {
        background: #444;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        text-decoration: none;
        transition: background 0.3s ease, transform 0.2s ease;
        border-radius: 8px;
    }
    .btn-secondary:hover {
        background: #555;
        transform: scale(1.05);
    }
</style>

