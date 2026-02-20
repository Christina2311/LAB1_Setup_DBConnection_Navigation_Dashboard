<?php
include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS C FROM clients"))["C"];
$services = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS C FROM services"))["C"];
$bookings = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS C FROM bookings"))["C"];

$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS S FROM payments"));
$revenue = $revRow["S"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include "nav.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-5">Dashboard</h2>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="card p-5 text-center h-100">
                    <i class="bi bi-people-fill display-4 mb-3 text-dark"></i>
                    <h6 class="text-muted">Total Clients</h6>
                    <h3 class="display-6"><?php echo $clients; ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-5 text-center h-100">
                    <i class="bi bi-gear-fill display-4 mb-3 text-dark"></i>
                    <h6 class="text-muted">Total Services</h6>
                    <h3 class="display-6"><?php echo $services; ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-5 text-center h-100">
                    <i class="bi bi-calendar-check-fill display-4 mb-3 text-dark"></i>
                    <h6 class="text-muted">Total Bookings</h6>
                    <h3 class="display-6"><?php echo $bookings; ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-5 text-center h-100">
                    <i class="bi bi-currency-dollar display-4 mb-3 text-dark"></i>
                    <h6 class="text-muted">Total Revenue</h6>
                    <h3 class="display-6">₱<?php echo number_format($revenue, 2); ?></h3>
                </div>
            </div>
        </div>

        <div class="mt-5 d-flex align-items-center justify-content-start px-3">
            <span class="fw-bold me-3">Quick links:</span>
            <a href="/assessment_beginner/page/client_add.php" class="btn btn-outline-primary btn-sm me-2">Add Client</a>
            <a href="/assessment_beginner/page/booking_create.php" class="btn btn-outline-success btn-sm">Create Booking</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>