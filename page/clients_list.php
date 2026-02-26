<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id ASC");
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <title>Clients List</title>
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
                            <h2 class="m-0 text-start">Client Directory</h2>
                            <a href="clients_add.php" class="btn btn-primary btn-sm btn-half">
                                <i class="bi bi-plus-lg"></i> Add New Client
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['client_id']; ?></td>
                                            <td><strong><?php echo $row['full_name']; ?></strong></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td class="text-center">
                                                <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
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
    </body>
</html>