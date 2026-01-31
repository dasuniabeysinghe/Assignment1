<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("../includes/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $q = mysqli_query($conn,
        "SELECT * FROM admins WHERE username='$username' AND password='$password'"
    );

    if (mysqli_num_rows($q) === 1) {
        $_SESSION['admin'] = $username;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark d-flex align-items-center justify-content-center vh-100">

<div class="card shadow-lg p-4" style="width: 360px;">
    <h3 class="text-center mb-3">Admin Login</h3>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button name="login" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
    </form>
</div>

</body>
</html>
