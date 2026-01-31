<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/db.php");

// Get user ID
if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found";
    exit();
}

// Fetch roles
$roles_result = mysqli_query($conn, "SELECT * FROM roles");

// Handle update
if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];

    mysqli_query($conn, "UPDATE users SET username='$username', email='$email', role_id=$role_id WHERE id=$id");

    header("Location: users.php");
    exit();
}
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" name="role_id" required>
                <?php while($role = mysqli_fetch_assoc($roles_result)) { ?>
                    <option value="<?= $role['id'] ?>" <?= $role['id']==$user['role_id']?'selected':'' ?>><?= $role['role_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
        <a href="users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
