<?php
session_start();
include 'config.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $date = $_POST['date'];
    $by_person = $_POST['by_person'];
    $particulars = $_POST['particulars'];
    $deposit = $_POST['deposit'];
    $withdrawal = $_POST['withdrawal'];

    // Insert data into database
    $sql = "INSERT INTO transactions (date, by_person, particulars, deposit, withdrawal)
            VALUES ('$date', '$by_person', '$particulars', '$deposit', '$withdrawal')";

    $conn->query($sql);
    header("location:index.php");
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete data from database
    $sql = "DELETE FROM transactions WHERE id=$id";

    $conn->query($sql);
    header("location:index.php");
}

// Fetch data from database
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Transactions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'back_button.php'; ?>
    <div class="container">
        <div class="form-container">
            <h2>Financial Transactions</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="by_person">By:</label>
                    <input type="text" id="by_person" name="by_person" required>
                </div>
                <div class="form-group">
                    <label for="particulars">Particulars:</label>
                    <textarea id="particulars" name="particulars" required></textarea>
                </div>
                <div class="form-group">
                    <label for="deposit">Deposit:</label>
                    <input type="number" id="deposit" name="deposit" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="withdrawal">Withdrawal:</label>
                    <input type="number" id="withdrawal" name="withdrawal" step="0.01" required>
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <div class="table-container">
            <h3>Transaction Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>By</th>
                        <th>Particulars</th>
                        <th>Deposit</th>
                        <th>Withdrawal</th>
                        <th>Balance (Deposit - Withdrawal)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $balance = $row['deposit'] - $row['withdrawal'];
                            echo "<tr>
                                    <td>{$row['date']}</td>
                                    <td>{$row['by_person']}</td>
                                    <td>{$row['particulars']}</td>
                                    <td>{$row['deposit']}</td>
                                    <td>{$row['withdrawal']}</td>
                                    <td>$balance</td>
                                    <td><a href='?delete={$row['id']}' class='delete-btn'>Delete</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
