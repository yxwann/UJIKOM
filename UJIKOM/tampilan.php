<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">


<body>

    <header class="header">
        <h1>Galeri Foto</h1>


        <div class="auth-buttons">
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-register">Register</a>
        </div>
    </header>

    <main class="gallery-container">
        <?php

        if ($koneksi) {
            $foto_query = mysqli_query($koneksi, "SELECT * FROM foto");
            if ($foto_query && mysqli_num_rows($foto_query) > 0) {
                while ($foto = mysqli_fetch_array($foto_query)) {
                    $foto_id = $foto['id_foto'];
                    $judul = htmlspecialchars($foto['judul'], ENT_QUOTES, 'UTF-8');
                    $gambar = "gambar/" . htmlspecialchars($foto['gambar'], ENT_QUOTES, 'UTF-8');
                    echo "
                        <div class='gallery-item'>
                            <img src='$gambar' alt='$judul'>
                            <div class='photo-info'>
                                <h3>$judul</h3>
                            </div>
                        </div>
                    ";
                }
            } else {
                echo "<p class='no-photos'>Tidak ada foto yang tersedia.</p>";
            }
        } else {
            echo "<p class='no-photos'>Gagal menghubungkan ke database.</p>";
        }
        ?>
    </main>

    <style>
        /* Retro CSS Theme */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #2e2e2e;
            color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            text-align: center;
            padding: 20px;
            color: #ffc107;
        }

        .header h1 {
            font-size: 3rem;
            margin: 0;
            text-shadow: 2px 2px #000;
        }

        .header p {
            font-size: 1.2rem;
            color: #f0e68c;
            margin-top: 5px;
        }

        /* Styling the auth buttons */
        .auth-buttons {
            margin-top: 20px;
        }

        .auth-buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 1.1rem;
            background-color: #ffc107;
            color: #2e2e2e;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .auth-buttons a:hover {
            background-color: #ffb300;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            gap: 15px;
        }

        .gallery-item {
            background-color: #3a3a3a;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 220px;
            transition: transform 0.3s;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .photo-info {
            text-align: center;
            margin-top: 10px;
        }

        .photo-info h3 {
            font-size: 1.2rem;
            margin: 5px 0;
            color: #ffc107;
        }

        .no-photos {
            color: #f0e68c;
            font-size: 1.5rem;
            text-align: center;
            margin-top: 50px;
        }
    </style>

</body>

</html>