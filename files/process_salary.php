<?php
// Include database connection file (config.php)
include 'config.php';

// Retrieve form data
$employee_id = $_POST['employee_id'];
$month = $_POST['month'];
$earning = $_POST['earning'];
$received = $_POST['received'];
$payable_receivable = $_POST['payable_receivable'];

// SQL query to insert salary details
$sql = "INSERT INTO salary_details (employee_id, month, earning, received, payable_receivable) 
        VALUES ('$employee_id', '$month', '$earning', '$received', '$payable_receivable')";

if ($conn->query($sql) === TRUE) {
    // Redirect back to employee manager page after successful insertion
    header("Location: employee_manager.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
