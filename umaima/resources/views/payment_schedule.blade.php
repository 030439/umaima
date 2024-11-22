<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .total-cell {
            text-align: right;
        }
    </style>
</head>
<body>

    <h1>Payment Schedule</h1>

    <table>
        <thead>
            <tr>
                <th>Payment Type</th>
                <th>Due Amount</th>
                <th>Due Date</th>
                <th>Amount Paid</th>
                <th>Paid On</th>
                <th>Outstanding</th>
                <th>Surcharge</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the payment schedules here -->
            @foreach ($formattedSchedules as $schedule)
    <tr>
        <td>{{ $schedule['payment_type'] }}</td>
        <td>{{ $schedule['due_amount'] }}</td>
        <td>{{ $schedule['due_date'] }}</td>
        <td>{{ $schedule['amount_paid'] }}</td>
        <td>{{ $schedule['paid_on'] }}</td>
        <td>{{ $schedule['outstanding'] }}</td>
        <td>{{ $schedule['surcharge'] }}</td>
    </tr>
@endforeach

        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="1" class="total-cell">Total</td>
                <td>{{ $totalDueAmount }}</td>
                <td></td>
                <td>{{ $totalAmountPaid }}</td>
                <td></td>
                <td>{{ $totalReceipts }}</td>
                <td>{{ $totalOutstanding }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
