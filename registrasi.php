<?php
include 'config.php'; // Pastikan file ini berisi koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $nomor = $_POST['nomor'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $password = $_POST['password'];
    $passwordKonfirmasi = $_POST['passwordKonfirmasi'];

    if ($password !== $passwordKonfirmasi) {
        echo "Password dan Konfirmasi Password tidak sama.";
    } elseif (empty($latitude) || empty($longitude)) {
        echo "Lokasi belum dipilih. Silakan pilih lokasi pada peta.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            $sql = "INSERT INTO users (email, nama, nomor, latitude, longitude, password) VALUES ('$email', '$nama', '$nomor', '$latitude', '$longitude', '$hashedPassword')";
            if ($conn->query($sql) === TRUE) {
                echo "success"; // Jika berhasil, kirim respons 'success' ke Ajax
            } else {
                echo "Gagal melakukan registrasi. Silakan coba lagi.";
            }
        }
    }
}
?>
