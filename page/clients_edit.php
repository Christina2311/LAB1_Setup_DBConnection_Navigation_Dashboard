<?php
include "../db.php";
$id = intval($_GET['id']);
$get = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);

if (isset($_POST['update'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  mysqli_query($conn, "UPDATE clients SET full_name='$full_name', email='$email', phone='$phone', address='$address' WHERE client_id=$id");
  header("Location: clients_list.php");
  exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <?php include "../nav.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h2 class="mb-4">Update Client Profile</h2>
                    
                    <form method="post" style="background: none; box-shadow: none; width: 100%; margin: 0; padding: 0;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo $client['full_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $client['email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $client['phone']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $client['address']; ?>">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-primary">Update Information</button>
                            <a href="clients_list.php" class="btn btn-link text-muted">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>