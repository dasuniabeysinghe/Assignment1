<?php
include("includes/db.php");
$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM products WHERE id=$id")
);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    mysqli_query($conn,
        "UPDATE products SET name='$name', price='$price' WHERE id=$id"
    );

    header("Location: products.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Update Product</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="<?= htmlspecialchars($data['price']) ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS CDN (optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
