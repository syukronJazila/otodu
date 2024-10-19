<?php
session_start();
include "functions.php";

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM murid"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;

$awalData = ($jumlahDataPerHalaman * ($halamanAktif - 1));

/* Mengambil Bagian data yang terletak di index $awalData kemudian berapa data yang ditampilkan setelahnya */
$murid = query("SELECT * FROM murid LIMIT $awalData, $jumlahDataPerHalaman");

if(isset($_POST["cari"])){
    $murid = cari($_POST["keyword"]);
}

 /* var_dump(phpinfo()); */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <style>
        *{
            background-color:azure;
        }
        
        h1{
            text-align: center;
        }
        
        a{
            margin-right: 10px;
        }
        
        form{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #keyword{
            padding: 5px;
        }
        
        #tombolCari{
            padding: 5px 10px;
            border: none;
            background-color: green;
            color: white;
            display:none;
        }

        #loading{
            width:30px;
            position:absolute;
            right:115px;
            z-index: -1;
            display:none;
        }
        
        table{
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td{
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover{
            background-color: #f5f5f5;
        }
        
        @media print{
            #logout, #garis, #tambah, #cari, #pagination, #aksi, #cetak, hr{
                display:none;
            }
        }
    
    </style>
</head>
<body>
    
    <a href="logout.php" id="logout">Logout</a> <span id="garis">|</span> <a href ="cetak.php" id="cetak">Cetak</a>
        
    <h1>Database Admin</h1>
    
    <div>
        <a href="tambah.php" id="tambah">Tambah Data</a>
    </div>
    
    <hr>
    
    <div id="pagination">
        <?php if($halamanAktif > 1): ?>
            <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo</a>
        <?php endif; ?>
        
        <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
            <?php if($i == $halamanAktif): ?>
                <a href="?halaman=<?= $i ?>" style="font-weight:bold; color:red;"><?= $i; ?></a>
            <?php else: ?>
            <a href="?halaman=<?= $i ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if($halamanAktif < $jumlahHalaman): ?>
            <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo</a>
        <?php endif; ?>
    </div>

    
    <hr>
    
    <div>
        <form action="" method="POST" id="cari">
            <input type="text" name="keyword" size="40" placeholder="Masukkan Kata Kunci.." autofocus autocomplete id="keyword">
            <button type="submit" name="cari" id="tombolCari">Cari</button>

            <img src="img/loading.gif" id="loading">
        </form>
    </div>
    
    <hr>
    
    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
        
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>E-mail</th>
        </tr>
        
        <?php $i= 1; 
        foreach($murid as $row): 
        ?> 

        <tr>
            <td><?= $i+$awalData ?></td>
            <td id="aksi"><a href="ubah.php?id=<?= $row["id"]; ?>&nama=<?= $row["nama"]; ?>&email=<?= $row["email"]; ?>&gambar=<?= $row["gambar"]; ?>">Ubah</a> | 
                <a href="hapus.php?id=<?= $row["id"]; ?>&" >Hapus</a></td>
            <td><img src="img/<?= $row["gambar"]; ?>" alt="Foto Profil" width="40"></td>
            <td>
                <?= $row["nama"]; ?>
            </td>
            <td><?= $row["email"]; ?></td>
          
        </tr>
        <?php $i++; endforeach; ?>
       </table>
    </div>
    
    <script src="jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
