<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $employee_type = $_POST['employee_type'];

    // Insert the new employee into the database
    $sql = "INSERT INTO employees (name, age, phone, address, employee_type)
            VALUES ('$name', '$age', '$phone', '$address', '$employee_type')";

    if ($conn->query($sql) === TRUE) {
        echo "New employee registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
