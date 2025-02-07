<?php
require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisManBuk - landing page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/stylesheet.css">
</head>
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">SisManBuk</a>
            <div>
                <a href="login.php" class="btn btn-secondary">masuk</a>
                <a href="register.php" class="btn btn-primary">daftar</a>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">memanjemen perbukuanmu dengan mudah!</h1>
            <a href="register.php" class="btn btn-primary btn-lg">mulai menjadi disiplin hari ini!</a>
        </div>
    </section>
    <section class="container my-5 bg-dark">
        <h2 class="text-center mb-5">Fitur</h2>
        <div class="row g-3">
            <div class="col-md-7">
                <div class="feature-card text-center">
                    <i class="bi bi-book feature-icon"></i>
                    <h4>Manajemen</h4>
                    <p>Tambah, edit, dan rapikan koleksi bukumu dengan nyaman</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <i class="bi bi-search feature-icon"></i>
                    <h4>Pencarian buku</h4>
                    <p>terlalu banyak buku? tenang saja sistem pencarian buku kami akan mencarikan bukumu dengan mudah</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
            <div class="container text-center"> 
                <p>Project mid BNCC LNT back end</p>
            </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>