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
                <th align="center" style="font-weight: bold; ">CLIENT INCOME</th>
                <th align="center" style="font-weight: bold; ">COMPANY INCOME</th>
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
                    <td>{{ $con->client_income }}</td>
                    <td>{{ $con->company_income }}</td>
                    <td>{{ $con->payment_date }}</td>
                    <td>{{ $con->due_date }}</td>
                    <td>{{ $con->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
