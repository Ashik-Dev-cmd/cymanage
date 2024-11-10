<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'back_button.php'; ?>
    <div class="container">
        <h2>Employee Manager</h2>
        
        <!-- Select Employee and Input Salary Details Form -->
        <form action="process_salary.php" method="post">
            <div class="form-group">
                <label for="employee_id">Select Employee:</label>
                <select id="employee_id" name="employee_id" required>
                    <?php
                    // Include database connection file (config.php)
                    include 'config.php';

                    // Fetch all employees from database and order them by category
                    $sql = "SELECT id, name, employee_type FROM employees ORDER BY employee_type, name";
                    $result = $conn->query($sql);

                    $current_category = '';
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($current_category != $row['employee_type']) {
                                if ($current_category != '') {
                                    echo "</optgroup>";
                                }
                                $current_category = $row['employee_type'];
                                echo "<optgroup label='" . ucfirst($current_category) . "'>";
                            }
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                        if ($current_category != '') {
                            echo "</optgroup>";
                        }
                    } else {
                        echo "<option value=''>No employees found</option>";
                    }

                    // Close database connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="month">Month:</label>
                <input type="text" id="month" name="month" required>
            </div>
            <div class="form-group">
                <label for="earning">Earning:</label>
                <input type="number" id="earning" name="earning" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="received">Received:</label>
                <input type="number" id="received" name="received" step="0.01" min="0" required>
            </div>

            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>
</body>
</html>
