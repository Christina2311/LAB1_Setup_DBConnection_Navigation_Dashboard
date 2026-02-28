<?php
include "../config/db.php";
 
$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Payments</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
    </head>

    <body class="bg-light">
        <?php include "../components/nav.php"; ?>
        
        <div class="container mt-5 p-5">
            <div class="row justify-content-center">
                <div class="col-md-11 p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="m-0 text-start">Payments</h2>
                    </div>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                        </tr>
                            
                        <?php while($p = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                            <td><?php echo $p['payment_id']; ?></td>
                            <td><?php echo $p['full_name']; ?></td>
                            <td><?php echo $p['booking_id']; ?></td>
                            <td>₱<?php echo number_format($p['amount_paid'],2); ?></td>
                            <td><?php echo $p['method']; ?></td>
                            <td><?php echo $p['payment_date']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    
    </body>
</html>