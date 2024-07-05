<?php

session_start();

include 'config/app.php';

// Periksa apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Periksa username
    $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

    // Jika user ada
    if (mysqli_num_rows($result) == 1) {
        // Ambil data user
        $hasil = mysqli_fetch_assoc($result);

        // Periksa kata sandi
        if (password_verify($password, $hasil['password'])) {
            // Set variabel session
            $_SESSION['login']    = true;
            $_SESSION['id_akun']  = $hasil['id_akun'];
            $_SESSION['nama']     = $hasil['nama'];
            $_SESSION['username'] = $hasil['username'];
            $_SESSION['email']    = $hasil['email'];
            $_SESSION['level']    = $hasil['level'];

            // Arahkan ke index.php
            header("Location: index.php");
            exit;
        }
    }
    // Jika username/password salah
    $error = true;
}

?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            user-select: none;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link href="assets/img/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<main class="form-signin">
    <form action="" method="POST">
        <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Login Admin</h1>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center">
                <b>Username/Password SALAH</b>
            </div>
        <?php endif; ?>

        <div class="form-floating">
            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username..." required>
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password..." required>
            <label for="floatingPassword">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
</main>
</body>
</html>
