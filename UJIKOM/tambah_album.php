<?php
session_start();  //    


$server = "localhost";
$username = "root";
$password = "";
$database = "ujikom";

// Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "ukk_galeri");

// Cek koneksi, jika gagal, tampilkan pesan error dan hentikan eksekusi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error()); // Menampilkan pesan error jika koneksi gagal
}

// Memeriksa apakah pengguna sudah login
if (isset($_SESSION['user']['id_user'])) {
    $id_user = $_SESSION['user']['id_user'];  // Menyimpan ID pengguna

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_album = $_POST['nama_album'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal = $_POST['tanggal'];

        // Query untuk menambahkan album ke dalam database
        $query = "INSERT INTO album (nama_album, deskripsi, tanggal, id_user) 
                  VALUES ('$nama_album', '$deskripsi', '$tanggal', '$id_user')";

        // Menjalankan query
        if (mysqli_query($koneksi, $query)) {
            // Jika query berhasil, tampilkan alert dan redirect ke halaman album
            echo '<script>alert("Album Telah Ditambahkan"); location.href = "?page=album";</script>';
        } else {
            //jika gagal, tampilkan pesan error
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }
} else {
    // Jika belum login, kembali ke halaman login
    header("Location: login.php");
    exit;
}
?>


<div class="container-fluid px-4">
    <h1 class="mt-4 text-center page-title">Tambah Album</h1>
    <form method="POST" class="album-upload-form">
        <div class="form-card">
            <table class="table table-borderless">
                <tr>
                    <td>
                        <label for="nama_album">Nama Album:</label>
                    </td>
                    <td>
                        <input type="text" id="nama_album" name="nama_album" class="form-control" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="deskripsi">Deskripsi:</label>
                    </td>
                    <td>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="tanggal">Tanggal Rilis:</label>
                    </td>
                    <td>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Tambah Album</button>
                        <button type="reset" class="btn btn-secondary mt-3 ms-2">Reset</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<style>
    .container-fluid {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #333, #555);
        color: #ffffff;
        padding: 20px;
        animation: fadeInBackground 1s ease;
    }

    .page-title {
        color: #ffd700;
        font-family: 'Courier New', Courier, monospace;
        font-size: 3rem;
        text-shadow: 2px 2px 0px #000, -2px -2px 0px #000, 4px 4px 0px #ff8c00;
        margin-bottom: 20px;
    }

    .form-card {
        background: #1c1c1c;
        border-radius: 12px;
        padding: 30px 20px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
        animation: slideIn 0.8s ease;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .table td {
        vertical-align: middle;
    }

    .table td label {
        font-weight: bold;
        color: #ffd700;
    }

    .form-control, .form-select, textarea {
        border-radius: 8px;
        border: 1px solid #444;
        background-color: #333;
        color: #ffffff;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
        width: 100%;  
        height: 50px; 
    }

    textarea {
        height: 150px; 
    }

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


    .btn-back {
        background: red; /* Red color for the back button */
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none; /* Remove underline from link */
        transition: background 0.3s ease, transform 0.2s ease;
    }


    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-card {
            padding: 20px 15px; /* Reduced padding for smaller screens */
        }
        
        .page-title {
            font-size: 2rem; /* Adjust title size for smaller screens */
        }

        .form-control, textarea {
            height: 40px; /* Adjusted height for smaller screens */
        }

        textarea {
            height: 120px; /* Adjusted height for smaller screens */
        }
    }
</style> 
