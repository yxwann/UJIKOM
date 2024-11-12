<?php
include "koneksi.php";
if (isset($_POST['username'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_array($cek);
        $_SESSION['user'] = $data;
        echo '<script>alert("Selamat Datang '.$data['nama_lengkap'].'"); location.href="index.php";</script>';
    } else {
        echo '<script>alert("Username/Password salah");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Galery Foto</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center">Login Galery Foto</h3>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukan Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukan Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p class="text-center mt-3"><a href="register.php" class="text-link">Need an account? Register</a></p>
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

</style>
