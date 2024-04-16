{{-- <!DOCTYPE html>
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
                <th>Unit Owner</th>
                <th>Project</th>
                <th>Unit No.</th>
                <th>Rental</th>
                <th>Markup</th>
                <th>Deposit</th>
                <th>Asso Dues</th>
            </tr>
        </thead>
        <tbody>
            @php
                dd($properties);
                $check = count($property->asso_dues);
            @endphp

            @if (count($properties) > 0)

                @foreach ($properties as $property)
                    <tr>
                        <td rowspan>{{ $property->name }}</td>
                        <td>{{ $property->project }}</td>
                        <td>{{ $property->rental->rental }}</td>
                        <td>{{ $property->rental->makrup }}</td>
                        <td>{{ $property->rental->deposit }}</td>
                        @if ($property->asso_dues == null)
                            <td></td>
                        @else
                            <td>{{ $property->asso_dues->start }}</td>
                        @endif
                    </tr>
                @endforeach


            @endif
        </tbody>
    </table>

</body>

</html> --}}
