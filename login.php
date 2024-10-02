<?php
include 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session atau redirect ke index.html
            session_start();
            $_SESSION['username'] = $user['username']; // Simpan username di session
            header("Location: index.html");
            exit();
        } else {
            echo json_encode(["error" => true, "message" => "Password tidak sesuai."]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Email tidak ditemukan."]);
    }

    $stmt->close();
}

$conn->close();
?>
