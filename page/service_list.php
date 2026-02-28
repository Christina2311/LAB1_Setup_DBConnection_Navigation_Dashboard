<?php
include "../config/db.php";
 
 
/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
 
 
  // Soft delete (set is_active to 0)
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
 
 
  header("Location: services_list.php");
  exit;
}
 
 
/* ============================
   FETCH ALL SERVICES
   ============================ */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id ASC");
?>
 
 
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    </head>

    <body class="bg-light">
    <?php include "../components/nav.php"; ?>
    
    <div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Available Services</h2>
                <a href="services_add.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Service
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-dark">
                        <tr>
                            <th class="px-3">ID</th>
                            <th>Service Name</th>
                            <th>Hourly Rate</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td class="px-3 text-muted"><?php echo $row['service_id']; ?></td>
                                <td class="fw-bold"><?php echo $row['service_name']; ?></td>
                                <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                                <td class="text-center">
                                    <?php if ($row['is_active'] == 1): ?>
                                        <span class="badge bg-success px-3 py-2">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-3 py-2">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="service_edit.php?id=<?php echo $row['service_id']; ?>" 
                                           class="btn btn-outline-secondary">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <?php if ($row['is_active'] == 1): ?>
                                            <a href=".../page/service_list.php?delete_id=<?php echo $row['service_id']; ?>"
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Deactivate this service?')">
                                                <i class="bi bi-slash-circle"></i> Deactivate
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>