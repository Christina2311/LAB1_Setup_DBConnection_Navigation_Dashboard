<?php
include "../config/db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $hourly_rate = $_POST['hourly_rate'];
  $is_active = $_POST['is_active'];
 
  // simple validation
  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
 
    header("Location: services_list.php");
    exit;
  }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Service</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
    </head>
    
    <body class="bg-light">
      <?php include "../components/nav.php"; ?>
      
      <div class="container mt-5 p-5">
        <div class="row justify-content-center">
          <div class="col-md-6 p-4 bg-white rounded shadow">
            <h2 class="mt-5">Add Service</h2>

            
            <?php if ($message): ?>
              <div class="alert alert-danger" style="color:red;">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="post">
              <div class="mb-2">
                <label class="form-label fw-bold">Service Name*</label>
                <input type="text" name="service_name" class="form-control" placeholder="e.g Engine Tune-up">
              </div>

              <div class="mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" rows="4" cols="40" class="form-control"></textarea>
              </div>

              <div class="mb-2" rows="4" cols="40">
                <label class="form-label fw-bold">Hourly Rate (₱)*</label>
                <input type="number" step="0.01" name="hourly_rate" class="form-control">
              </div>
              
              <div class="mb-2">
                <label class="form-label fw-bold">Active?</label>
                <select name="is_active" class="form-select">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
              </div>
              
              <div class="d-grid gap-2 mt-4">
                <button type="submit" name="save" class="btn btn-primary">Save Service</button>
                <a href="services_list.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </body>
</html>