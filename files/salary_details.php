<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Details</title>
    <style>
        /* Internal CSS for styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
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
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup input {
            margin-top: 10px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
<?php include 'back_button.php'; ?>
    <div class="container">
        <h2>Salary Details</h2>
        
        <?php
        include 'config.php';

        if (isset($_GET['employee_id']) && !empty($_GET['employee_id'])) {
            $employee_id = $_GET['employee_id'];

            $employee_query = "SELECT * FROM employees WHERE id = $employee_id";
            $employee_result = $conn->query($employee_query);

            if ($employee_result->num_rows > 0) {
                $employee_row = $employee_result->fetch_assoc();
                $employee_name = $employee_row['name'];

                echo "<h3>Employee: $employee_name</h3>";

                $salary_query = "SELECT id, month, earning, received, payable_receivable, earning_leave, casual_leave 
                                 FROM salary_details 
                                 WHERE employee_id = $employee_id";
                $salary_result = $conn->query($salary_query);

                if ($salary_result->num_rows > 0) {
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>
                            <th>Month</th>
                            <th>Basic Salary</th>
                            <th>House Rent</th>
                            <th>Earning Leave</th>
                            <th>Casual Leave</th>
                            <th>Total Earning</th>
                            <th>Received</th>
                            <th>Payable/Receivable</th>
                          </tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $total_earning = 0;
                    $total_received = 0;

                    while ($salary_row = $salary_result->fetch_assoc()) {
                        $house_rent = $salary_row['earning'] * 0.60;
                        $total_earning_current = $salary_row['earning'] + $house_rent + $salary_row['earning_leave'] + $salary_row['casual_leave'];
                        $payable_receivable = $total_earning_current - $salary_row['received'];

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($salary_row['month']) . "</td>";
                        echo "<td class='earning'>" . htmlspecialchars($salary_row['earning']) . "</td>";
                        echo "<td>" . htmlspecialchars($house_rent) . "</td>";
                        echo "<td class='earning-leave' data-id='" . htmlspecialchars($salary_row['id']) . "'>" . htmlspecialchars($salary_row['earning_leave']) . "</td>";
                        echo "<td class='casual-leave' data-id='" . htmlspecialchars($salary_row['id']) . "'>" . htmlspecialchars($salary_row['casual_leave']) . "</td>";
                        echo "<td class='total-earning'>" . htmlspecialchars($total_earning_current) . "</td>";
                        echo "<td class='received'>" . htmlspecialchars($salary_row['received']) . "</td>";
                        echo "<td class='payable-receivable'>" . htmlspecialchars($payable_receivable) . "</td>";
                        echo "</tr>";

                        $total_earning += $total_earning_current;
                        $total_received += $salary_row['received'];
                    }

                    echo "</tbody>";
                    echo "<tfoot>";
                    echo "<tr>
                            <td>Total</td>
                            <td id='total-earning'>$total_earning</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id='total-total-earning'>$total_earning</td>
                            <td id='total-received'>$total_received</td>
                            <td></td>
                          </tr>";
                    echo "</tfoot>";
                    echo "</table>";
                } else {
                    echo "No salary details found for this employee.";
                }
            } else {
                echo "Employee not found.";
            }
        } else {
            echo "Invalid request.";
        }

        $conn->close();
        ?>

        <div class="overlay"></div>
        <div class="popup">
            <h3>Enter number of days</h3>
            <input type="number" id="days-input" min="0" />
            <button id="submit-btn">Submit</button>
        </div>
    </div>

    <script>
        document.querySelectorAll('.earning-leave, .casual-leave').forEach(item => {
            item.addEventListener('click', (e) => {
                const cell = e.target;
                const earning = parseFloat(cell.closest('tr').querySelector('.earning').innerText);
                const totalEarningCell = cell.closest('tr').querySelector('.total-earning');
                const payableReceivableCell = cell.closest('tr').querySelector('.payable-receivable');
                const received = parseFloat(cell.closest('tr').querySelector('.received').innerText);
                document.querySelector('.popup').style.display = 'block';
                document.querySelector('.overlay').style.display = 'block';

                document.getElementById('submit-btn').onclick = () => {
                    const days = parseFloat(document.getElementById('days-input').value);
                    const calculatedValue = (earning / 26) * days;

                    cell.innerText = calculatedValue.toFixed(2);
                    document.querySelector('.popup').style.display = 'none';
                    document.querySelector('.overlay').style.display = 'none';

                    const houseRent = parseFloat(cell.closest('tr').querySelector('td:nth-child(3)').innerText);
                    const earningLeave = parseFloat(cell.closest('tr').querySelector('.earning-leave').innerText);
                    const casualLeave = parseFloat(cell.closest('tr').querySelector('.casual-leave').innerText);
                    const newTotalEarning = earning + houseRent + earningLeave + casualLeave;
                    totalEarningCell.innerText = newTotalEarning.toFixed(2);

                    const newPayableReceivable = newTotalEarning - received;
                    payableReceivableCell.innerText = newPayableReceivable.toFixed(2);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_leave.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('id=' + cell.getAttribute('data-id') + '&column=' + cell.className + '&value=' + calculatedValue);
                };
            });
        });

        document.querySelector('.overlay').onclick = () => {
            document.querySelector('.popup').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        };
    </script>
</body>
</html>
