<?php
include 'config.php';

if (isset($_POST['id']) && isset($_POST['column']) && isset($_POST['value'])) {
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    // Ensure the column is valid
    if (in_array($column, ['earning-leave', 'casual-leave'])) {
        // Convert column name for the database
        $column = str_replace('-', '_', $column);

        // Update the database
        $stmt = $conn->prepare("UPDATE salary_details SET $column = ? WHERE id = ?");
        $stmt->bind_param("di", $value, $id);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    }
}

$conn->close();
?>
``
