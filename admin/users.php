<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/db.php");

// Handle form submission for adding a new user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password
    $role_id = $_POST['role_id'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password, $role_id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit();
}

// Fetch all users
$users_result = mysqli_query($conn, "SELECT u.id, u.username, r.role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id");

// Fetch all roles for dropdown
$roles_result = mysqli_query($conn, "SELECT * FROM roles");
?>

<div class="container mt-4">
    <h2 class="mb-4">Users Management</h2>

    <!-- Add User Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Add New User</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="role_id" required>
                        <option value="">Select Role</option>
                        <?php while($role = mysqli_fetch_assoc($roles_result)) { ?>
                            <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Existing Users</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users_result)) { ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['role_name'] ?? 'No Role' ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
