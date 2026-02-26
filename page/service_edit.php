<?php
include "../db.php";
$id = intval($_GET['id']);
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = mysqli_real_escape_string($conn, $_POST['service_name']);
  $desc = mysqli_real_escape_string($conn, $_POST['description']);
  $rate = mysqli_real_escape_string($conn, $_POST['hourly_rate']);
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: service_list.php"); 
  exit;
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <title>Edit Service</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body class="bg-light">
        <?php include "../nav.php"; ?>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm">
                        <h2 class="mb-4">Edit Service Details</h2>
                    
                        <form method="post" style="background: none; box-shadow: none; width: 100%; margin: 0; padding: 0;">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Service Name</label>
                                <input type="text" name="service_name" class="form-control" value="<?php echo $service['service_name']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="4"><?php echo $service['description']; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hourly Rate (₱)</label>
                                <input type="number" step="0.01" name="hourly_rate" class="form-control" value="<?php echo $service['hourly_rate']; ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Availability Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Active / Available</option>
                                    <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>Inactive / Hidden</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="update" class="btn btn-primary">Update Service</button>
                                <a href="service_list.php" class="btn btn-link text-muted">Cancel and Return</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>