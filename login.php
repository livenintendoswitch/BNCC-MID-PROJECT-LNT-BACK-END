<?php
session_start(); 
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, password FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Query gagal: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) { 
                $_SESSION['user_id'] = $user['id']; 
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Password salah!, coba inget ulang";
            }
        } else {
            $error = "nama user ga ketemu!";
        }

        $stmt->close();
    } else {
        $error = "kolom diisi semua!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisManBuk - Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/stylesheet.css">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="form-card bg-white p-4 rounded shadow mt-5" style="max-width: 400px; margin: auto;">
            <h2 class="text-center mb-4">Masuk</h2>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">
                Belum punya akun? <a href="register.php">Daftar</a>
            </p>
        </div>
    </div>
</body>
</html>
