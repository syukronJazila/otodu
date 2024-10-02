<?php
header('Content-Type: application/json');
include 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendResponse(true, "Email tidak valid.");
        }

        // Cek apakah email atau username sudah ada
        $sql_check = "SELECT * FROM user WHERE email = ? OR username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $email, $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            sendResponse(true, "Email atau username sudah terdaftar.");
        }

        // Jika tidak ada duplikasi, lakukan insert
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (email, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            sendResponse(true, "Gagal mempersiapkan statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $email, $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect ke halaman login
            // header("Location: login.html?registered=success");
            // echo 'tesss';
            sendResponse(false, 'Register berhasil');
            // exit();
        } else {
            echo 'tessss else';
            sendResponse(true, "Gagal menambahkan user: " . $stmt->error);
        }

        $stmt->close();
    } else {
        sendResponse(true, "Data tidak lengkap untuk menambahkan user baru.");
    }
} else {
    sendResponse(true, "Metode HTTP tidak valid.");
}

$conn->close();

function sendResponse($error, $message) {
    echo json_encode(['error' => $error, 'message' => $message]);
    exit();
}
?>
