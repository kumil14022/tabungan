<?php 
require_once 'koneksi.php';
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['btnLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    if ($data = mysqli_fetch_assoc($query)) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['id_user'] = $data['id_user'];
            header("Location: dashboard.php");
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Username atau Password salah!')
                    window.history.back();
                </script>
            ";
            exit;
        }
    }
    else
    {
        echo "
            <script>
                alert('Username atau Password salah!')
                window.history.back();
            </script>
        ";
        exit;
    }
}
?>

<!--halaman login-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Halaman Login Buku Tabungan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-img">
    <div class="login-box">
        <h1>Login</h1>
        <form method="POST">
            <div class="textbox">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="textbox">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password">
            </div>

            <input type="submit" class="submit" name="btnLogin" value="Sign in">
        </form>
    </div>
</body>
</html>