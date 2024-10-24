<?php
session_start();
include 'config.php';  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Email dan password harus diisi.";
        exit();
    }

    // Menggunakan prepared statement untuk mencegah SQL Injection
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Simpan informasi user ke session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nama'];
            $_SESSION['user_email'] = $row['email'];

            echo "success"; // Kirim respons success ke AJAX
        } else {
            echo "Password salah.";
        }
    } else {
        echo "User tidak ditemukan.";
    }

    // Tutup prepared statement dan koneksi
    $stmt->close();
}
$conn->close();
?>
