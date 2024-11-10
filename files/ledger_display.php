<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Display</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #007BFF;
            color: #fff;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ledger Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Receipt/Bill</th>
                    <th>Amount</th>
                    <th>Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php
                error_reporting(0);
                include 'config.php';

                $sql = "SELECT * FROM ledger";
                $result = $conn->query($sql);

                $total_amount = 0;
                $total_paid = 0;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['receipt_bill'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "<td>" . $row['paid'] . "</td>";
                        echo "</tr>";

                        $total_amount += $row['amount'];
                        $total_paid += $row['paid'];
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }

                $payable_amount = $total_amount - $total_paid;
                $conn->close();
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td><?php echo $total_amount; ?></td>
                    <td><?php echo $total_paid; ?></td>
                </tr>
                <tr>
                    <td colspan="4">Payable Amount</td>
                    <td><?php echo $payable_amount; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
