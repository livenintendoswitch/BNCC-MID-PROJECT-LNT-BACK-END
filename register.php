<?php
session_start();
require 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (strlen($password) < 8) {
        $error = "Password harus minimal 8 karakter!";
    } else {
        $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Gagal mendaftar: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisManBuk - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/stylesheet.css">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="form-card bg-white">
            <h2 class="text-center mb-4">Daftar akun</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                    <div class="form-text">kata sandi harus lebih atau sama dengan 8</div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
            <p class="text-center mt-3">
                sudah pengguna lama? <a href="login.php">masuk</a>
            </p>
        </div>
    </div>
</body>
</html>