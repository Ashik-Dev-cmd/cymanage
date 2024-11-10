<?php

// sales_details.php
include 'config.php';
include 'back_button.php'; 
error_reporting(0);
$party_id = isset($_GET['party_id']) ? (int)$_GET['party_id'] : 0;

// Fetch party details
$sql = "SELECT * FROM parties WHERE id = $party_id";
$party_result = $conn->query($sql);
if ($party_result->num_rows == 0) {
    die("Error: Party with id $party_id does not exist.");
}
$party = $party_result->fetch_assoc();

$record_saved = false; // Variable to check if the record was saved

// Handle form submission (Save or Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $date = $_POST['date'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $unit_price = $_POST['unit_price'];
    $bill_amount = $_POST['bill_amount'];
    $deposit = $_POST['deposit'];
    $account_payable_receivable = $_POST['account_payable_receivable'];

    // Handle file uploads
    $uploads_dir = 'uploads/';

    $po_file = uploadFile($_FILES['po_file'], $uploads_dir);
    $money_receipt_file = uploadFile($_FILES['money_receipt_file'], $uploads_dir);
    $check_file = uploadFile($_FILES['check_file'], $uploads_dir);
    $bill_no_file = uploadFile($_FILES['bill_no_file'], $uploads_dir);

    // Calculate bill amount
    $bill_amount = $quantity * $unit_price;
    $account_payable_receivable = $bill_amount - $deposit;

    if ($id > 0) {
        // Update existing record
        $sql = "UPDATE sales_details SET date='$date', status='$status', description='$description', quantity='$quantity', unit='$unit', unit_price='$unit_price', deposit='$deposit', 
                po_file='$po_file', money_receipt_file='$money_receipt_file', check_file='$check_file', bill_no_file='$bill_no_file', bill_amount='$bill_amount' WHERE id=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO sales_details (party_id, date, status, description, quantity, unit, unit_price, deposit, 
                po_file, money_receipt_file, check_file, bill_no_file, bill_amount) 
                VALUES ('$party_id', '$date', '$status', '$description', '$quantity', '$unit', '$unit_price', '$deposit', 
                '$po_file', '$money_receipt_file', '$check_file', '$bill_no_file', '$bill_amount')";
    }
    
    if ($conn->query($sql) === TRUE) {
        $record_saved = true; // Set the variable to true if the record was saved
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete record if requested
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['record_id'])) {
    $record_id = (int)$_GET['record_id'];
    $sql_delete = "DELETE FROM sales_details WHERE id = $record_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Record deleted successfully.');</script>";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}

// Fetch sales details with bill amount calculation
$sql = "SELECT *, (quantity * unit_price) AS bill_amount FROM sales_details WHERE party_id = $party_id";
$sql = "SELECT *, (bill_amount - deposit) AS account_payable_receivable FROM sales_details WHERE party_id = $party_id";
$details_result = $conn->query($sql);

// Function to handle file uploads
function uploadFile($file, $uploads_dir) {
    if ($file['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $file['tmp_name'];
        $name = basename($file['name']);
        $upload_path = $uploads_dir . $name;
        move_uploaded_file($tmp_name, $upload_path);
        return $upload_path;
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Details</title>
    <style>
        /* Internal CSS for styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 1300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Handle horizontal overflow */
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .edit-button {
            background-color: #ffc107;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 10px;
            margin-right: 5px;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .collapsible {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border: none;
            text-align: center;
            outline: none;
            font-size: 15px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .active, .collapsible:hover {
            background-color: #0056b3;
        }

        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f9f9f9;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sales Details for <?php echo htmlspecialchars($party['name']); ?></h2>
        <button type="button" class="collapsible">Add/Edit Record</button>
        <div class="content">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" id="status" name="status" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="po_file">PO File</label>
                    <input type="file" id="po_file" name="po_file">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="unit">Unit</label>
                    <input type="text" id="unit" name="unit" required>
                </div>
                <div class="form-group">
                    <label for="unit_price">Unit Price</label>
                    <input type="number" step="0.01" id="unit_price" name="unit_price" required>
                </div>
                <div class="form-group">
                    <label for="deposit">Deposit</label>
                    <input type="number" step="0.01" id="deposit" name="deposit">
                </div>
                <div class="form-group">
                    <label for="money_receipt_file">Money Receipt File</label>
                    <input type="file" id="money_receipt_file" name="money_receipt_file">
                </div>
                <div class="form-group">
                    <label for="check_file">Check File</label>
                    <input type="file" id="check_file" name="check_file">
                </div>
                <div class="form-group">
                    <label for="bill_no_file">Bill No. File</label>
                    <input type="file" id="bill_no_file" name="bill_no_file">
                </div>
                <div class="form-group">
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
        
        <?php if ($record_saved): ?>
            <script>
                alert('Record saved successfully.');
            </script>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>PO File</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Bill Amount</th>
                    <th>Deposit</th>
                    <th>Account Payable/Receivable</th>
                    <th>Money Receipt File</th>
                    <th>Check File</th>
                    <th>Bill No. File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $details_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['date']); ?></td>
                        <td><?php echo htmlspecialchars($detail['status']); ?></td>
                        <td><?php echo htmlspecialchars($detail['description']); ?></td>
                        <td>
                            <?php if ($detail['po_file']): ?>
                                <a href="<?php echo htmlspecialchars($detail['po_file']); ?>" target="_blank">View File</a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($detail['unit']); ?></td>
                        <td><?php echo htmlspecialchars($detail['unit_price']); ?></td>
                        <td><?php echo htmlspecialchars($detail['bill_amount']); ?></td>
                        <td><?php echo htmlspecialchars($detail['deposit']); ?></td>
                        <td><?php echo htmlspecialchars($detail['account_payable_receivable']); ?></td>
                        <td>
                            <?php if ($detail['money_receipt_file']): ?>
                                <a href="<?php echo htmlspecialchars($detail['money_receipt_file']); ?>" target="_blank">View File</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($detail['check_file']): ?>
                                <a href="<?php echo htmlspecialchars($detail['check_file']); ?>" target="_blank">View File</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($detail['bill_no_file']): ?>
                                <a href="<?php echo htmlspecialchars($detail['bill_no_file']); ?>" target="_blank">View File</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="edit-button" onclick="editRecord(<?php echo $detail['id']; ?>)">Edit</button>
                            <button class="delete-button" onclick="deleteRecord(<?php echo $detail['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript to toggle the collapsible form
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }

        // JavaScript function to handle the edit button click
        function editRecord(id) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_sales_detail.php?id=" + id, true); // Create get_sales_detail.php to fetch details
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById("id").value = data.id;
                    document.getElementById("date").value = data.date;
                    document.getElementById("status").value = data.status;
                    document.getElementById("description").value = data.description;
                    document.getElementById("quantity").value = data.quantity;
                    document.getElementById("unit").value = data.unit;
                    document.getElementById("unit_price").value = data.unit_price;
                    document.getElementById("deposit").value = data.deposit;
                }
            };
            xhr.send();
        }

        // JavaScript function to handle the delete button click
        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "sales_details.php?party_id=<?php echo $party_id; ?>&action=delete&record_id=" + id;
            }
        }
    </script>
</body>
</html>
