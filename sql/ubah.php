<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

include "functions.php";

$id = $_GET["id"];
$nama = $_GET["nama"];
$email = $_GET["email"];
$gambar = $_GET["gambar"];

if(isset($_POST["submit"])){

    $hasil = ubah($_POST, $id, $gambar, $_FILES["gambar"]);
       
    if ($hasil) {
        $baris = mysqli_affected_rows($conn);
        echo "
            <script>
                alert('Data Berhasil Diubah\\n" . $baris . " Baris Terpengaruh');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        $error = mysqli_error($conn);
        echo "
            <script>
                alert('Gagal\\nError: " . addslashes($error) . "');
            </script>
        ";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data</title>
    <style>
        *{
            background-color:azure;
        }
        
        li{
            margin-bottom:10px;
        }
       
    </style>
</head>
<body>
    
    <h1>Ubah Data</h1>
    
    <div>
        <form action="" method="POST" enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="nama">Nama: </label>
                    <input type="text" name="nama" id="nama" value="<?= $nama ?>"required>
                </li>
                
                <li>
                    <label for="email">E-mail: </label>
                    <input type="text" name="email" id="email" value="<?= $email ?>" required>
                </li>
                
                <li>
                    <label for="gambar">Gambar: </label> <br>
                    <img src="img/<?= $gambar ?>" alt="Foto Profil" width="100"> <br>
                    <input type="file" name="gambar" id="gambar">
                </li>
                
                <li>
                    <button type="submit" name="submit">Ubah Data</button>
                </li>
            </ul>
        </form>
    </div>
    
</body>
</html>
