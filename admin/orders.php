<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/db.php");

$orders = mysqli_query($conn, "SELECT * FROM orders");
?>

<div class="container-fluid p-4">
    <h3 class="mb-3">Orders</h3>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($orders)): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $row['customer_name'] ?></td>
                        <td>$<?= $row['total'] ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $row['status']=='Completed' ? 'success' : 
                                ($row['status']=='Pending' ? 'warning' : 'secondary')
                            ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
