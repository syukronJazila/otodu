<?php
session_start();
include "functions.php";

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

if(isset($_POST["submit"])){
    
    $hasil = tambah($_POST);
    
    if ($hasil) {
        $baris = mysqli_affected_rows($conn);
        echo "
            <script>
                alert('Data Berhasil Ditambahkan\\n" . $baris . " Baris Terpengaruh');
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
    <title>Tambah Data</title>
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
    
    <h1>Tambah Data</h1>
    
    <div>
        <form action="" method="POST" enctype="multipart/form-data">
            <ul>
                <li>
                    <label for="nama">Nama: </label>
                    <input type="text" name="nama" id="nama" required>
                </li>
                
                <li>
                    <label for="email">E-mail: </label>
                    <input type="text" name="email" id="email" required>
                </li>
                
                <li>
                    <label for="gambar">Gambar: </label>
                    <input type="file" name="gambar" id="gambar">
                </li>
                
                <li>
                    <button type="submit" name="submit">Tambah Data</button>
                </li>
            </ul>
        </form>
    </div>
    
</body>
</html>
