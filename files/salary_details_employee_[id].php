
<?php include 'back_button.php'; ?>
<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Basic Salary</th>
            <th>Received</th>
            <th>Payable/Receivable</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic content for salary details can be added here -->
        <tr>
            <td>January</td>
            <td class="earning">2000</td>
            <td class="received">1800</td>
            <td class="payable-receivable">200</td>
        </tr>
        <tr>
            <td>February</td>
            <td class="earning">2000</td>
            <td class="received">2000</td>
            <td class="payable-receivable">0</td>
        </tr>
        <!-- More rows as needed -->
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td id="total-earning"></td>
            <td id="total-received"></td>
            <td></td>
        </tr>
    </tfoot>
</table>

