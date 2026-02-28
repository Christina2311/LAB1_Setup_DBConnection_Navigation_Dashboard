<?php
include "../config/db.php";
 
$booking_id = $_GET['booking_id'];
 
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
 
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");
 
    // 2) Recompute total paid (after insert)
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];

    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;

    // 4) If fully paid, update booking status to PAID
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
 
    header("Location: bookings_list.php");
    exit;
  }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Process Payment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body class="bg-light">
        <?php include "../components/nav.php"; ?>
        
      <div class="container mt-5 pt-4">
        <div class="row justify-content-center">
          <div class="col-md-8 p-4 shadow-sm bg-white">
            <div class="card p-4 shadow-sm">
              <h2 class="mb-4 text-center">Process Payment (Booking #<?php echo $booking_id; ?>)</h2>
              
              <div class="alert alert-secondary text-center mb-4">
                <p class="mb-1">Total Cost: <strong>₱<?php echo number_format($booking['total_cost'],2); ?></strong></p>
                <p class="mb-1">Total Paid: <strong>₱<?php echo number_format($total_paid,2); ?></strong></p>

                <hr>
                <h4 class="mb-0"><b>Balance: ₱<?php echo number_format($balance,2); ?></b></h4>
              </div>  
              
              <?php if ($message): ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
              <?php endif; ?>
              
              <form method="post">
                <div class="md-3 text-start mt-3">
                  <label class="form-label fw-bold">Amount Paid</label>
                  <input type="number" name="amount_paid" step="0.01" class="form-control" placeholder="0.00" required>
                </div>  
                
                <div class="md-3 text-start mt-3">
                  <label class="form-label fw-bold">Method</label>
                  <select name="method" class="form-select">
                      <option value="CASH">CASH</option>
                      <option value="GCASH">GCASH</option>
                      <option value="CARD">CARD</option>
                  </select>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                  <button type="submit" name="pay" class="btn btn-primary">Save Payment</button>
                  <a href="bookings_list.php" class="btn btn-secondary">Back to Bookings</a>
                </div>
              </form>
            </div>
        </div>
      </div>
    </body>
</html>