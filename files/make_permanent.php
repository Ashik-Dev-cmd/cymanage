<?php
include 'config.php';

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Update employee type to permanent
    $sql = "UPDATE employees SET employee_type = 'permanent' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        echo "Employee has been made permanent.";
    } else {
        echo "Error updating employee: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the trial employees list page
    header("Location: trial_employees_list.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
