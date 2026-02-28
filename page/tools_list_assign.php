<?php
include "../config/db.php";
 
$message = "";
 
// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
 
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
 
    $message = "Tool assigned successfully!";
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <title>Tools Assignment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">

        <style>
            .card:hover {
                transform: none !important;
                top: 0 !important;
            }
            form {
                background: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        </style>
    </head>
    <body class="bg-light">

        <?php include "../components/nav.php"; ?>

        <div class="container mt-5 pt-4">
            <h2 class="mb-5 text-center">Tools Management</h2>

            <?php if($message): ?>
                <div class="alert alert-info text-center w-50 mx-auto"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="row g-4 justify-content-center">
                
                <div class="col-md-5">
                    <div class="card p-4 shadow-sm h-100">
                        <h4 class="mb-4 text-center"><i class="bi bi-tools"></i> Inventory List</h4>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Total</th>
                                        <th>Available</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    mysqli_data_seek($tools, 0);
                                    while($t = mysqli_fetch_assoc($tools)) { ?>
                                    <tr>
                                        <td class="text-start"><strong><?php echo $t['tool_name']; ?></strong></td>
                                        <td class="text-start"><strong><?php echo $t['quantity_total']; ?></strong></td>
                                        <td>
                                            <span class="badge <?php echo ($t['quantity_available'] > 0) ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo $t['quantity_available']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card p-4 shadow-sm h-100">
                        <h4 class="mb-4 text-center"><i class="bi bi-clipboard-plus"></i> Assign to Booking</h4>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Booking ID</label>
                                <select name="booking_id" class="form-select">
                                    <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
                                    <option value="<?php echo $b['booking_id']; ?>">Booking #<?php echo $b['booking_id']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Tool</label>
                                <select name="tool_id" class="form-select">
                                    <?php
                                    $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                                    while($t2 = mysqli_fetch_assoc($tools2)) { ?>
                                    <option value="<?php echo $t2['tool_id']; ?>">
                                        <?php echo $t2['tool_name']; ?> (Stock: <?php echo $t2['quantity_available']; ?>)
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Quantity Used</label>
                                <input type="number" name="qty_used" min="1" value="1" class="form-control">
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="assign" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div> 
    </body>
</html>