<!-- back_button.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .back-button-container {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="back-button-container">
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
