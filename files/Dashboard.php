<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <style>
        /* Reset some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #478CCF;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 20px;
        }

        .sidebar ul li {
            padding: 10px;
            cursor: pointer;
            position: relative;
            transition: 0.2s;
        }

        .sidebar ul li:hover {
            background-color: #4535C1;
        }

        .sidebar ul li .submenu {
            display: none;
            list-style: none;
            padding-left: 20px;
            
        }

        .sidebar ul li .submenu li{
            padding: 10px 10px 10px 30px;
            
        }
        .submenu li a{
            font-size: 15px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        .submenu li a:hover {
            color: red;
        }
        .sidebar ul li.active > .submenu {
            display: block;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li>
                BANK >
                <ul class="submenu">
                    <li><a href="index.php">One Bank</a></li>
                </ul>
            </li>
            <li>
                Employee >
                <ul class="submenu">
                    <li><a href="employee_manager.php">Employee Manager</a></li>
                    <li><a href="employee_list.php">Employee List</a></li>
                    <li><a href="employee_registration.php">Employee Registration</a></li>
                </ul>
            </li>
            <li>
                Party >
                <ul class="submenu">
                    <li><a href="party_manager.php">Party Manager</a></li>
                    <li><a href="purchase_party_list.php">Purchase Party</a></li>
                    <li><a href="sales_party_list.php">Sales Party</a></li>
                </ul>
            </li>
            <li>
                Daily Workers >
                <ul class="submenu">
                    <li><a href="trial_employees_list.php">Trial Employees</a></li>
                    <li><a href="day_labor_list.php">Daily Basis Employees</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome to the Cashier Dashboard</h1>
        <p>Select an option from the sidebar to get started.</p>
    </div>

    <script>
        document.querySelectorAll('.sidebar ul li').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
