<?php
require 'connect.php'; 
require 'authentication.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['judul']);
    $author = trim($_POST['penulis']);
    $publisher = trim($_POST['publisher']);
    $page_number = intval($_POST['total_halaman']);
    $user_id = $_SESSION['user_id']; 

    if (empty($name) || empty($author) || empty($publisher) || $page_number <= 0) {
        die("input ga bener. kalo ngetik yang bener.");
    }

    $sql = "INSERT INTO books (nama, author, publisher, page_number, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("error menjalani perintah: " . $conn->error);
    }

    $stmt->bind_param("sssii", $name, $author, $publisher, $page_number, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); 
        exit();
    } else {
        die("buku ga bisa dimasukin: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SisManBuk - Create Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/stylesheet.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Halaman Manajemen</a>
        <a href="index.html" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Tambah Buku Baru</h2>
    <form action="createBook.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="title" name="judul" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="author" name="penulis" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" required>
        </div>
        <div class="mb-3">
            <label for="pages" class="form-label">Total Halaman</label>
            <input type="number" class="form-control" id="pages" name="total_halaman" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Buku</button>
    </form>
</div>

<footer class="text-center mt-5">
    <p>Project mid BNCC LNT backend</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
