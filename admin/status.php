<?php
// status.php
include ('../koneksi/koneksi.php');

// Check if the id_prestasi parameter is set and not empty
if (isset($_GET['id_prestasi']) && !empty($_GET['id_prestasi'])) {
    // Sanitize the input to prevent SQL injection
    $id_prestasi = $koneksi->real_escape_string($_GET['id_prestasi']);

    // Get the current status of the prestasimahasiswa entry
    $currentStatusQuery = "SELECT id_status FROM prestasimahasiswa WHERE id_prestasi = $id_prestasi";
    $currentStatusResult = $koneksi->query($currentStatusQuery);

    if ($currentStatusResult->num_rows > 0) {
        $currentStatusRow = $currentStatusResult->fetch_assoc();
        $currentStatusId = $currentStatusRow['id_status'];

        // Determine the next status
        $nextStatusId = ($currentStatusId % 4) + 1;

        // Update the status of the prestasimahasiswa entry
        $updateQuery = "UPDATE prestasimahasiswa SET id_status = $nextStatusId WHERE id_prestasi = $id_prestasi";

        if ($koneksi->query($updateQuery) === TRUE) {
            // Display an alert
            echo '<script>alert("Status berhasil diubah.");</script>';

            // Redirect back to presma.php
            header('Location: presma.php');
            exit();
        } else {
            echo "Error updating status: " . $koneksi->error;
        }
    } else {
        echo "No prestasimahasiswa entry found for id_prestasi = $id_prestasi";
    }

    // Close the database connection
    $koneksi->close();
} else {
    echo "Invalid id_prestasi parameter";
}
?>
