<?php
// purchase_party_list.php
include 'config.php';

$sql = "SELECT * FROM parties WHERE type = 'Sales'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Party List</title>
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
            height: 100vh;
        }
        
        .container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        
        .party-list {
            margin-top: 20px;
        }
        
        .party-item {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            text-align: center;
        }
        
        .party-item:hover {
            background-color: #e9ecef;
        }
        
        .party-name {
            font-size: 18px;
            font-weight: bold;
            color: #4535C1;
            text-decoration: none;
            
        }
    </style>
</head>
<body>
<?php include 'back_button.php'; ?>
    <div class="container">
        <h2>Purchase Party List</h2>
        <div class="party-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="party-item">';
                    echo '<a class="party-name" href="sales_details.php?party_id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No purchase parties found.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
