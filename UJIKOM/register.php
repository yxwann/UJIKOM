<?php
include "koneksi.php"; // Menghubungkan ke file koneksi database

// Memeriksa apakah form sudah disubmit dan data username ada
if (isset($_POST['username'])) {
    // Mengambil data yang dikirim melalui POST
    $nama = $_POST['nama_lengkap'];  // Nama lengkap
    $email = $_POST['email'];        // Email
    $alamat = $_POST['alamat'];      // Alamat
    $username = $_POST['username'];  // Username
    $password = md5($_POST['password']);  // Menggunakan MD5 untuk mengenkripsi password

    // Cek apakah email sudah ada di database
    $cek_email = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        // Jika email sudah ada, tampilkan pesan error
        echo '<script>alert("Email sudah terdaftar, silahkan gunakan email lain.");</script>';
    } else {
        // Query untuk menyimpan data pengguna ke dalam tabel 'user'
        $query = mysqli_query($koneksi, "INSERT INTO user(nama_lengkap, email, alamat, username, password) 
                                          VALUES('$nama', '$email', '$alamat', '$username', '$password')");

        // Memeriksa apakah query berhasil
        if ($query) {
            echo '<script>alert("Register Berhasil, silahkan login");</script>';
        } else {
            echo '<script>alert("Register Gagal")</script>';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Galery Foto</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center">Register</h3>
            <form method="post">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukan Email" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukan Alamat" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukan Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukan Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <p class="text-center mt-3"><a href="login.php" class="text-link">Sudah Punya Akun? Login!</a></p>
        </div>
    </div>
</body>
</html>

<style>
    /* Container styling */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #333, #666);
        padding: 20px;
        animation: fadeInBackground 1s ease;
    }

    /* Form container styling */
    .form-container {
        background-color: #222;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        text-align: center;
        animation: slideIn 0.8s ease;
        color: #fff;
    }

    /* Input field styling */
    .form-control {
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #444;
        background-color: #333;
        color: #fff;
    }

    /* Button styling */
    .btn-primary {
        background: linear-gradient(45deg, #444, #000);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #555, #222);
        transform: scale(1.05);
    }

    /* Text link styling */
    .text-link {
        color: #bbb;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .text-link:hover {
        color: #888;
    }

    /* Fade-in animation */
    @keyframes fadeInBackground {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Slide-in animation */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
