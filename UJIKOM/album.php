<?php
// qquery untuk mendapatkan semua album dari database
$queryAlbum = mysqli_query($koneksi, "SELECT * FROM album");
?>

<div class="container-fluid px-4 custom-bg">
    <!-- bagian tombol untuk menambah galeri dan album -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="?page=galeri_tambah" class="btn btn-primary">+ Tambah Galeri</a> 
            <a href="tambah_album.php" class="btn btn-secondary">+ Tambah Album</a> 
        </div>
    </div>

    <div class="row">
        <?php
        // loop untuk menampilkan setiap album sebagai kartu
        while ($album = mysqli_fetch_array($queryAlbum)) {
            $album_id = $album['id_album']; 
            $album_nama = htmlspecialchars($album['nama_album']); 
            $album_deskripsi = htmlspecialchars($album['deskripsi']); 

            // menentukan URL folder album 
            $album_folder = "gambar/" . $album_nama;
        ?>

            <!-- album dalam bentuk kartu -->
            <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                <div class="card shadow-lg bg-dark text-white h-100 card-hover">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $album_nama; ?></h5> 
                        <p class="card-text"><?php echo $album_deskripsi; ?></p> 
                    </div>
                    <div class="card-footer">
                        <a href="?page=galeri_album&id_album=<?php echo $album_id; ?>" class="btn btn-primary btn-sm w-100">Lihat Album</a>
                    </div>
                </div>
            </div>
            
        <?php
        }
        ?>
    </div>
</div>



<style>
    /* bg container efek gradasi */
    .custom-bg {
        background: linear-gradient(135deg, #333, #555);
        min-height: 100vh;
        color: #ffffff;
        padding: 20px;
        animation: fadeInBackground 1s ease; /* animasi fade-in */
    }

    /* pengaturan dasar untuk kartu */
    .card {
        border-radius: 10px;
        transition: transform 0.3s, box-shadow 0.3s; /* Efek transisi */
        animation: slideIn 0.8s ease; /* animasi */
        background: #1c1c1c; /* bg */
    }

    /* Efek hover pada kartu */
  

    /* Gaya judul album dalam kartu */
    .card-title {
        font-size: 1.5rem;
        font-family: 'Courier New', Courier, monospace; /* Font */
        margin: 0;
        text-shadow: 1px 1px 0px #000, 2px 2px 0px #ff8c00; /* Efek */
    }

    /* gaya teks deskripsi album */
    .card-text {
        font-size: 1rem;
        font-family: 'Arial', sans-serif;
        margin: 0;
    }

    /* untuk tombol */
    .btn {
        border-radius: 5px;
        font-size: 0.9rem;
        padding: 10px 15px;
        transition: background-color 0.3s, transform 0.3s; /* efek transisi */
        font-family: 'Courier New', Courier, monospace; /* font */
    }

    
    .btn-primary {
        background-color: #ff8c00; /* warna tombol retro oranye */
        border: none; /* hapus border */
    }

    /* gaya khusus untuk tombol kedua */
    .btn-secondary {
        background-color: #444; /* Warna latar belakang gelap */
        border: none;
    }

 


</style>
