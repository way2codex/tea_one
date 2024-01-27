<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customerName }} - PDF Report</title>
</head>

<body>
    <h1>{{ $customerName }} </h1>
    <p>From: {{ $fromDate }} To: {{ $toDate }}</p>

    <table border="1" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="2">Date</th>
                <th>Total</th>
                <!-- Add other columns based on your data structure -->
            </tr>
        </thead>
        <tbody>
            @php
            $groupedData = $data->groupBy(function($item) {
            return $item->entry_time->format('d-m-Y');
            });

            $grandTotal = 0;
            @endphp

            @foreach ($groupedData as $date => $group)
            <tr>
                <td colspan="2">{{ $date }}</td>
                <td>{{ $group->sum('quantity') }}</td>
                <!-- Add other columns based on your data structure -->
            </tr>

            @php
            $grandTotal += $group->sum('quantity');
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Grand Total</strong></td>
                <td><strong>{{ $grandTotal }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>