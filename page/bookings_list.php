<?php
include "../db.php";
 
$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id ASC
";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
  <head>
    <meta charset="utf-8">
    <title>Bookings</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
  </head>
  
    <body class="bg-light">
        <?php include "../nav.php"; ?>
  
        <div class="container mt-5 p-5">
            <div class="row justify-content-center">
                <div class="col-md-11 p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="m-0 text-start">Bookings</h2>
                            <a href="bookings_create.php" class="btn btn-primary btn-sm px-4" style="flex: none; width: auto;">
                                <i class="bi bi-plus-lg"></i> Create Booking
                            </a>
                        </div>
    
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Hours</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        $display_id = 1;
                                        while($b = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $display_id++; ?></td>
                                            <td><strong><?php echo $b['client_name']; ?></strong></td>
                                            <td><?php echo $b['service_name']; ?></td>
                                            <td><?php echo date("M d, Y", strtotime($b['booking_date'])); ?></td>
                                            <td><?php echo $b['hours']; ?> hrs</td>
                                            <td>₱<?php echo number_format($b['total_cost'], 2); ?></td>
                                            <td>
                                                <span class="badge <?php echo ($b['status'] == 'PENDING') ? 'bg-warning text-dark' : 'bg-success'; ?>">
                                                    <?php echo $b['status']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn btn-outline-success btn-sm" style="flex: none; width: auto;">
                                                    Process
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