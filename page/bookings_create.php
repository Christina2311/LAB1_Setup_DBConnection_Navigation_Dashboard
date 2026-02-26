<?php
include "../db.php";
 
$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours = $_POST['hours'];
 
  // get service hourly rate
  $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
 
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>

<!doctype html>
  <head>
    <meta charset="utf-8">
    <title>Create Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
  </head>

  <body class="bg-light">
      <?php include "../nav.php"; ?>

          <div class="container mt-5 p-5">
            <div class="row justify-content-center">
              <div class="col-md-5 p-4 shadow-sm">
                    <h2 class="mb-4">Create Booking</h2>
      
                    <form method="post" style="background: none; box-shadow: none; width: 100%; margin: 0; padding: 0;">
                      <div class="mb-3">
                        <label class="form-label fw-bold">Client</label>
                        <select name="client_id" class="form-select" required>
                          <?php while($c = mysqli_fetch_assoc($clients)) { ?>
                            <option value="<?php echo $c['client_id']; ?>"><?php echo $c['full_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    
                      <label class="form-label fw-bold">Service</label>
                      <select name="service_id" class="form-select" required>
                        <?php while($s = mysqli_fetch_assoc($services)) { ?>
                          <option value="<?php echo $s['service_id']; ?>">
                            <?php echo $s['service_name']; ?> (₱<?php echo number_format($s['hourly_rate'],2); ?>/hr)
                          </option>
                        <?php } ?>
                      </select>
                    
                      <label class="form-label fw-bold">Date</label>
                      <input type="date" name="booking_date" class="form-control" required><br>
                    
                      <label class="form-label fw-bold">Hours</label>
                      <input type="number" name="hours" min="1" value="1" class="form-control"><br><br>
                    
                      <button type="submit" name="create" class="btn btn-success">Create Booking</button>
                      <a href="bookings_list.php" class="btn btn-link text-muted">Cancel</a>
                    </form>
              </div>
            </div>
          </div>
  </body>
</html>