<?php
require 'connect.php';
require 'authentication.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$book_id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
$user_id = $_SESSION['user_id'];

if ($book_id > 0) {
    $sql = "SELECT * FROM books WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $book_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $page_number = (int)$_POST['pages'];

    $sql = "UPDATE books SET nama = ?, author = ?, publisher = ?, page_number = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $name, $author, $publisher, $page_number, $book_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p class='text-danger'>Error updating book: " . $conn->error . "</p>";
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
    <title>SisManBuk - Update Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/stylesheet.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Halaman Manajemen</a>
        <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Buku</h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $book_id; ?>"> <!-- Hidden ID Field -->
        
        <div class="mb-3">
            <label for="title" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['nama'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="pages" class="form-label">Total Halaman</label>
            <input type="number" class="form-control" id="pages" name="pages" value="<?php echo htmlspecialchars($book['page_number'] ?? 0); ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Update Buku</button>
    </form>
</div>

<footer class="text-center mt-5">
    <p>Project mid BNCC LNT backend</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
