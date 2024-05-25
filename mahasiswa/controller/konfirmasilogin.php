    <?php
    session_start();

    include('../../admin/koneksi/koneksi.php');

    if (isset($_POST['login'])) {
        $email = $_POST['inputEmail'];
        $pass = $_POST['inputPassword'];

        if (empty($email)) {
            header("Location:../../login.php?failed=emptyEmail");
            exit();
        } else if (empty($pass)) {
            header("Location:../../login.php?failed=emptyPassword");
            exit();
        }

        $email = mysqli_real_escape_string($koneksi, $email);
        $stmt = mysqli_prepare($koneksi, "SELECT id_mahasiswa, password FROM mahasiswa WHERE email_mahasiswa = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id_user, $hashed_password);
            mysqli_stmt_fetch($stmt);

            if (password_verify($pass, $hashed_password)) {
                $_SESSION['id_mahasiswa'] = $id_user;
                header("Location:../index-user.php");
                exit();
            } else {
                header("Location:../../login.php?failed=wrongEmailPassword");
                exit();
            }
        } else {
            header("Location:../../login.php?failed=wrongEmailPassword");
            exit();
        }
    }
