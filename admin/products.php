<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/db.php");

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Products</h3>
        <a href="add_product.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($products)): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td>
                            <img src="../uploads/products/<?= $row['image'] ?>" 
                                 class="rounded" width="50">
                        </td>
                        <td><?= $row['name'] ?></td>
                        <td>$<?= $row['price'] ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this product?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
