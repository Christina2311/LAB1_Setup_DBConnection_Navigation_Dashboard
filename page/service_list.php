<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Services List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <?php include "../nav.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="m-0 text-start">Available Services</h2>
                        <a href="#" class="btn btn-primary btn-sm btn-half">
                            <i class="bi bi-plus-lg"></i> Add Service
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Service Name</th>
                                    <th>Hourly Rate</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['service_id']; ?></td>
                                        <td><strong><?php echo $row['service_name']; ?></strong></td>
                                        <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                                        <td>
                                            <?php if($row['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="service_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>