<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/db.php");

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/products/" . $image);

    mysqli_query($conn,
        "INSERT INTO products (name, price, image, description)
         VALUES ('$name','$price','$image','$desc')"
    );

    header("Location: products.php");
    exit();
}
?>

<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="products.php" class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button name="add" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Save Product
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
