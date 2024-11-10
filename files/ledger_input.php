<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Input</title>
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

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .add-btn {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            background-color: #0056b3;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .entry-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ledger Input</h2>
        <form action="insert_ledger.php" method="post">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div id="ledger-entries">
                <div class="entry-group">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description[]" required>
                    </div>
                    <div class="form-group">
                        <label for="receipt_bill">Receipt/Bill</label>
                        <input type="text" id="receipt_bill" name="receipt_bill[]" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount[]" required>
                    </div>
                    <div class="form-group">
                        <label for="paid">Paid</label>
                        <input type="number" id="paid" name="paid[]" required>
                    </div>
                </div>
            </div>
            <button type="button" class="add-btn" onclick="addEntry()">Add More</button>
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function addEntry() {
            const entryGroup = document.createElement('div');
            entryGroup.className = 'entry-group';

            entryGroup.innerHTML = `
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description[]" required>
                </div>
                <div class="form-group">
                    <label for="receipt_bill">Receipt/Bill</label>
                    <input type="text" id="receipt_bill" name="receipt_bill[]" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount[]" required>
                </div>
                <div class="form-group">
                    <label for="paid">Paid</label>
                    <input type="number" id="paid" name="paid[]" required>
                </div>
            `;

            document.getElementById('ledger-entries').appendChild(entryGroup);
        }
    </script>
    <a href="ledger_display.php">See the ledger details</a>
</body>
</html>
