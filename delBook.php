<?php
require 'connect.php';
require 'authentication.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $book_id = (int) $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM books WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $book_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "ada masalah dalam penghapusan buku: " . $conn->error;
    }
    $stmt->close();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$book_id = (int) $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapus Buku - SisManBuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/stylesheet.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Halaman Manajemen</a>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Apakah Anda yakin ingin menghapus buku ini?</h2>
    <p>Buku yang dihapus tidak dapat dipulihkan lagi.</p>
    <form action="delBook.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $book_id; ?>">
        <button type="submit" class="btn btn-danger">Hapus Buku</button>
        <a href="dashboard.php" class="btn btn-primary">Batal</a>
    </form>
</div>

<footer class="text-center mt-5">
    <p>Project mid BNCC LNT backend</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
