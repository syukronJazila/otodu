<?php

/* Digunakan untuk melihat animasi loding
sleep(1);
*/

include "functions.php";

$keyword = $_GET["keyword"];

$query = "SELECT * FROM murid
                WHERE
                nama like '%$keyword%' OR
                email like '%$keyword%' OR            
    ";
    
$murid = query($query);

?>

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
            <td><?= $i?></td>
            <td><a href="ubah.php?id=<?= $row["id"]; ?>&nama=<?= $row["nama"]; ?>&nim=<?= $row["nim"]; ?>&email=<?= $row["email"]; ?>&jurusan=<?= $row["jurusan"]; ?>&gambar=<?= $row["gambar"]; ?>">Ubah</a> | 
                <a href="hapus.php?id=<?= $row["id"]; ?>&" >Hapus</a></td>
            <td><img src="img/<?= $row["gambar"] ?>" alt="Foto Profil" width="40"></td>
            <td>
                <?= $row["nama"]; ?>
            </td>
            <td><?= $row["nim"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
            
        </tr>
        <?php $i++; endforeach; ?>
</table>
