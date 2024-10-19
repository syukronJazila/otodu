<?php
include "functions.php";

if(isset($_POST["register"])){
    
    $hasil = registrasi($_POST);
    
    if($hasil){
        echo "<script>
                alert(`Pendaftaran Berhasil!`);
                window.location.href = 'login.php';
              </script>";
        exit;
    }else{
        echo mysqli_error($conn);
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="full/bootstrapes/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/register.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <h2>Register</h2>
              </div>
              <form action="" method="POST" id="registerForm">
                  
                  <div class="form-group">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                  </div>
                  
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                  </div>
                  
                  <div class="form-group mb-4">
                    <label for="konfirmasiPassword" class="sr-only">Konfirmasi Password</label>
                    <input type="password" name="konfirmasiPassword" id="konfirmasiPassword" class="form-control" placeholder="Konfirmasi Password" required>
                  </div>
                  
                  <button name="register" id="login-btn" class="btn btn-block login-btn mb-4" type="submit">Daftar</button>
                </form>
                <p class="login-card-footer-text">Sudah punya akun? <a href="login.php" class="text-reset">Login disini</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
          <div class="col-md-5">
            <img src="assets/images/otodu.png" alt="login" class="login-card-img">
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
     
</body>
</html>
