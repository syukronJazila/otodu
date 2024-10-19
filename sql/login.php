<?php 
session_start();
include "functions.php";

$error = false;

if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
    $id = $_COOKIE["id"];
    $username = $_COOKIE["username"];
    
    $hasil = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $bagian = mysqli_fetch_assoc($hasil);
    
    if($key === hash('whirlpool', $bagian["username"])){
        $_SESSION["login"] = true;
    }
}

if(isset($_SESSION["login"]) === true){
    header("Location: index.php");
    exit;
}

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    /* Yang Dikembalikan Adalah Nilai Boolean */
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    
    /* Pengecekan Username Jika Hasil 1 Maka Terdapat Username Tersebut Di Database */
    if(mysqli_num_rows($cek) === 1){
        $bagian = mysqli_fetch_assoc($cek);
        if (password_verify($password, $bagian["password"])){
        
            $_SESSION["login"] = true;
            
            if(isset($_POST["remember"])){
                setcookie('id', $bagian["id"], time()+60);
                setcookie('key', hash('whirlpool', $bagian["username"]), time()+60);
            }
            
            header("Location: index.php");
            exit;
        }
    }
    
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link href="full/bootstrapes/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/login.css">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    
    <?php if($error): ?>
    <h3>Username Atau Password Salah</h3>
    <?php endif; ?>
    
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="assets/images/otodu.png" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <!-- <img src="assets/images/logo.svg" alt="logo" class="logo"> -->
                 <h1>Login</h1>
              </div>
              <form action="login.php" method="POST" id="loginForm">
                  <div class="form-group">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <button name="login" id="login-btn" class="btn btn-block login-btn mb-4" type="submit">Login</button>
                </form>
                <a href="#!" class="forgot-password-link">Lupa password?</a>
                <p class="login-card-footer-text">Belum punya akun? <a href="#!" class="text-reset">Daftar disini</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
    
    <script src="full/bootstrapes/dist/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
