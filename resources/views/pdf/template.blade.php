<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customerName }} - PDF Report</title>
</head>

<body>
    <center><h1>TEA ONE CENTER </h1></center>
    <p>Name : {{ $customerName }} </p>
    <p>From: {{ $fromDate }} To: {{ $toDate }}</p>

    <table border="1" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="">Date</th>
                <th>Tea</th>
                <th>Tea Price</th>
                <th>Cofee</th>
                <th>Cofee Price</th>
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
                <td colspan="">{{ $date }}</td>
                @php
                    $tea_total = $group->where('product_id',1)->sum('quantity') ?? 0;
                    $tea_price = $productData->where('id',1)->first()['price'];
                    $cofee_total = $group->where('product_id',2)->sum('quantity') ?? 0;
                    $cofee_price = $productData->where('id',2)->first()['price'];
                    $date_price_total = ($tea_total * $tea_price ) + ($cofee_total * $cofee_price);
                @endphp
                <td>{{ $tea_total }}</td>
                <td>{{ $tea_price }}</td>
                <td>{{ $cofee_total  }}</td>
                <td>{{ $cofee_price }}</td>
                <td> {{ $date_price_total  }}</td>
            </tr>

            @php
            $grandTotal += $date_price_total;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"><strong>Grand Total</strong></td>
                <td><strong>{{ $grandTotal }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>