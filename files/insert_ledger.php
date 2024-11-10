<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $descriptions = $_POST['description'];
    $receipt_bills = $_POST['receipt_bill'];
    $amounts = $_POST['amount'];
    $paids = $_POST['paid'];

    for ($i = 0; $i < count($descriptions); $i++) {
        $description = $descriptions[$i];
        $receipt_bill = $receipt_bills[$i];
        $amount = $amounts[$i];
        $paid = $paids[$i];

        $sql = "INSERT INTO ledger (date, description, receipt_bill, amount, paid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii', $date, $description, $receipt_bill, $amount, $paid);

        if ($stmt->execute()) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
