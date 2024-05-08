<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>


    <table>
        <thead>
            <tr>
                <th style="font-weight: bold; ">CLIENT NAME</th>
                <th align="center" style="font-weight: bold; ">PROPERTY DETAILS</th>
                <th align="center" style="font-weight: bold; ">COORDINATOR</th>
                <th align="center" style="font-weight: bold; ">CONTACT</th>
                <th align="center" style="font-weight: bold; ">AGENT</th>
                <th align="center" style="font-weight: bold; ">CONTRACT START</th>
                <th align="center" style="font-weight: bold; ">CONTRACT END</th>
                <th align="center" style="font-weight: bold; ">PAYMENT TERM</th>
                <th align="center" style="font-weight: bold; ">TENANT PRICE</th>
                <th align="center" style="font-weight: bold; ">OWNER INCOME</th>
                <th align="center" style="font-weight: bold; ">ABIC INCOME</th>
                <th align="center" style="font-weight: bold; ">PAYMENT DATE</th>
                <th align="center" style="font-weight: bold; ">DUE DATE</th>
                <th align="center" style="font-weight: bold; ">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contracts as $con)
                <tr>
                    <td>{{ $con->client }}</td>
                    <td align="center">{{ $con->property_details }}</td>
                    <td>{{ $con->coordinator }}</td>
                    <td>{{ $con->contact }}</td>
                    <td>{{ $con->agent }}</td>
                    <td>{{ $con->contract_start }}</td>
                    <td>{{ $con->contract_end }}</td>
                    <td>{{ $con->payment_term }}</td>
                    <td>{{ $con->tenant_price }}</td>
                    <td>{{ $con->owner_income }}</td>
                    <td>{{ $con->company_income }}</td>
                    <td>{{ $con->payment_date }}</td>
                    <td>{{ $con->due_date }}</td>

                    @php $status = count(explode(' ', $con->status)); @endphp
                    
                    @if ($status == 3)
                        <td style="color: #dc3545;">{{ $con->status }}</td>
                    @elseif ($status == 4)
                        <td style="color: #198754;">{{ $con->status }}</td>
                    @else 
                        <td style="color: #0d6efd;">{{ $con->status }}</td>
                    @endif

                    

                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
