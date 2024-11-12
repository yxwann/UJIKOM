<?php

// Pastikan user sudah login
if (!isset($_SESSION['user']['id_user'])) {
    die("Anda harus login terlebih dahulu.");
}

$id_user_login = $_SESSION['user']['id_user']; // ID pengguna yang login

// Query untuk mendapatkan foto, album, dan informasi pengunggah
$query = mysqli_query($koneksi, "SELECT foto.*, album.nama_album, user.nama_lengkap 
                                 FROM foto 
                                 LEFT JOIN album ON album.id_album = foto.id_album 
                                 LEFT JOIN user ON user.id_user = foto.id_user");

?>

<div class="container-fluid px-4 custom-bg">
    <div class="top-buttons mb-3">
        <a href="?page=galeri_tambah" class="btn btn-primary">+ Tambah Galeri</a>

        <?php if ($id_user_login) { ?>
            <button id="editButton" class="btn btn-warning ms-2" disabled onclick="editSelected()">Ubah</button>
            <button id="deleteButton" class="btn btn-danger ms-2" disabled onclick="deleteSelected()">Hapus</button>
        <?php } ?>
    </div>

    <form id="photoForm" method="post">
        <div class="row">
            <?php while ($data = mysqli_fetch_array($query)) {
                $id_foto = $data['id_foto'];
                $nama_user = htmlspecialchars($data['nama_lengkap']);
            ?>
                <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-lg bg-dark text-white h-100 card-hover">
                        <input type="checkbox" class="select-photo" name="selected_photos[]" value="<?php echo $id_foto; ?>" onclick="toggleButtons()">
                        <a href="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" target="_blank">
                            <img src="gambar/<?php echo htmlspecialchars($data['gambar']); ?>" class="card-img-top" alt="gambar" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($data['judul']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($data['deskripsi']); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($data['tanggal']); ?></small></p>
                            <p class="card-text"><small>Pengunggah: <?php echo $nama_user; ?></small></p>
                            <p class="card-text"><strong><?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likefoto WHERE id_foto = $id_foto")); ?> Likes</strong></p>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-6">
                                    <a href="?page=galeri_like&id=<?php echo $id_foto; ?>" class="btn btn-success btn-sm"><i class="fas fa-thumbs-up"></i> Like</a>
                                </div>
                                <div class="col-6">
                                    <a href="?page=galeri_komentar&id=<?php echo $id_foto; ?>" class="btn btn-primary btn-sm"><i class="fas fa-comments"></i> Comment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </form>
</div>


<!--JavaScript -->
<script>
    function toggleButtons() {
        const selectedPhotos = document.querySelectorAll('.select-photo:checked');
        document.getElementById('deleteButton').disabled = selectedPhotos.length === 0;
        document.getElementById('editButton').disabled = selectedPhotos.length === 0;
    }

    // untuk hapus foto yang dipilih
    function deleteSelected() {
        if (confirm('Yakin ingin menghapus foto yang dipilih?')) {
            const selectedPhotos = document.querySelectorAll('.select-photo:checked');
            let selectedIds = [];
            selectedPhotos.forEach(photo => selectedIds.push(photo.value));

            let form = document.getElementById('photoForm');
            form.action = '?page=galeri_hapus';
            form.submit();
        }
    }

    //  untuk ubah foto yg dipilih
    function editSelected() {
        const selectedPhotos = document.querySelectorAll('.select-photo:checked');
        if (selectedPhotos.length === 1) {
            const photoId = selectedPhotos[0].value;
            window.location.href = `?page=galeri_ubah&id=${photoId}`;
        } else {
            alert('Silakan pilih satu foto saja untuk diubah.');
        }
    }
</script>

<!-- Tambahkan CSS -->
<style>
    .custom-bg {
        background: linear-gradient(135deg, #1a1a1a, #2e2e2e);
        min-height: 100vh;
        color: #ffffff;
        padding: 20px;
        animation: fadeInBackground 1s ease;
    }

    .card {
        border-radius: 10px;
        transition: transform 0.3s, box-shadow 0.3s;
        animation: slideIn 0.8s ease;
        background: #3b3b3b;
        position: relative;
    }



    .card-title {
        font-size: 1.5rem;
        font-family: 'Courier New', Courier, monospace;
        margin: 0;
    }

    .card-text {
        font-size: 1rem;
        font-family: 'Arial', sans-serif;
        margin: 0;
    }

    .btn {
        border-radius: 5px;
        font-size: 0.9rem;
        padding: 10px 15px;
        transition: background-color 0.3s, transform 0.3s;
        font-family: 'Courier New', Courier, monospace;
    }

    .btn-primary {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .top-buttons {
        display: flex;
        justify-content: flex-start;
        gap: 10px;
        margin-bottom: 20px;
    }

    .card-footer .row {
        display: flex;
        gap: 10px;
        justify-content: space-between;
    }

    .card-footer .col-6 {
        flex: 1;
        padding: 0;
    }

    .btn-sm {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        padding: 8px;
    }

    .select-photo {
        position: absolute;
        top: 10px;
        right: 10px;
        transform: scale(1.5);
    }
</style>