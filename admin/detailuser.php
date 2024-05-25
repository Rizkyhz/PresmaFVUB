<?php
include('koneksi/koneksi.php');

// Check if user ID is provided in the URL
if (isset($_GET['id_user'])) {
    $userId = $_GET['id_user'];

    // Fetch user details based on the provided ID
    $sql = "SELECT `username`,`password`, `email`, `nama_role` FROM `user` INNER JOIN user_role ON user.id_role = user_role.id_role WHERE id_user = $userId";
    $query = mysqli_query($koneksi, $sql);

    // Check if the user exists
    if ($query && mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];
        $role = $userData['nama_role'];
    } else {
        // Redirect to the user list page if the user does not exist
        header("Location: user.php");
        exit();
    }
} else {
    // Redirect to the user list page if no user ID is provided
    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php") ?>
    <title>User Details</title>
    <!-- Add any additional styles or meta tags as needed -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #007bff;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("includes/header.php") ?>
        <?php include("includes/sidebar.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <!-- ... (same as your existing code) ... -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="color:black;"><i class="fas fa-user"></i> Detail User</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $email; ?></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><?php echo $password; ?></td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td><?php echo $role; ?></td>
                            </tr>
                            <!-- Add more user details as needed -->
                        </table>
                        <div class="mt-3">
                            <a href="user.php" class="btn btn-warning " style="font-weight: 500;">Back</a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("includes/footer.php") ?>
    </div>
    <!-- ./wrapper -->
    <?php include("includes/script.php") ?>
</body>
</html>
