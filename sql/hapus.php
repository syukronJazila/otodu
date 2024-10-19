<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

include "functions.php";

$id = $_GET["id"];

// Cek jika parameter 'delete' ada di URL dan bernilai 'true'
if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    // Proses penghapusan data
    $hasil = hapus($id);
    $baris = mysqli_affected_rows($conn);
    
    if ($baris > 0) {
        echo "<script>
            alert('Data Berhasil Dihapus\\n" . $baris . " Baris Terpengaruh');
            document.location.href = 'index.php';
        </script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>
            alert('Gagal\\nError: " . addslashes($error) . "');
            document.location.href = 'index.php';
        </script>";
    }
    exit; // Menghentikan eksekusi lebih lanjut setelah penghapusan
}

// Jika parameter 'delete' tidak ada, tampilkan konfirmasi
echo "<script>
    var konfirmasi = confirm('Yakin Ingin Menghapus Data?');
    if (konfirmasi) {
        // Arahkan ke halaman yang sama dengan parameter 'delete=true'
        window.location.href = 'hapus.php?id=$id&delete=true';
    } else {
        // Jika dibatalkan, arahkan ke halaman utama
        window.location.href = 'index.php';
    }
</script>";

?>
