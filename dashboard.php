<?php
require 'connect.php';
require 'authentication.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("ga ada akses. masuk dulu bang");
}

$user_id = $_SESSION['user_id'];
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

if (!empty($search)) {
    $sql = "SELECT * FROM books WHERE user_id = ? AND nama LIKE ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $searchParam = "%" . $search . "%";  
    $stmt->bind_param("is", $user_id, $searchParam);
} else {
    $sql = "SELECT * FROM books WHERE user_id = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SisManBuk - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/stylesheet.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Halaman Manajemen</a>
        <div>
            <a href="logout.php" class="btn btn-danger">Keluar</a>
        </div>
    </div>
</nav>

<section class="hero-section text-center">
    <h1>Selamat Datang di Halaman Manajemen SisManBuk</h1>
    <p>Sortir bukumu dengan mudah</p>
</section>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <a href="createBook.php" class="btn btn-success btn-lg">Tambahkan Buku Baru</a>

        <form action="dashboard.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Judul Buku..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <h2 class="mt-4">Daftar Buku</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Jumlah Halaman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['publisher']}</td>
                        <td>{$row['page_number']}</td>
                        <td>
                            <a href='updateBook.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delBook.php?id={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Tidak ada buku ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer class="text-center mt-5">
    <p>Project mid BNCC LNT backend</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
