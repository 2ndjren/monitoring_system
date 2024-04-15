<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Property Monitoring Listings System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet" />
</head>


<body>
    <div class="mailer"
        style="
         font-family: 'Courier Prime', monospace; width: 80vw; height: auto; background:
        rgb(255, 255, 255); padding: 10px; margin: auto;">
        <h4>Good Day!</h4>
        <p>
            Dear {{ $mail['receiver'] }}, I hope this email finds you well. I am writing to inform
            you about an important matter regarding the property contract for Unit
            No. {{ $mail['unit_no'] }} in {{ $mail['project'] }}, currently under the ownership of
            {{ $mail['unit_owner'] }}. <br />
            <br />
            The contract for the aforementioned property is set to expire within 7
            days, from {{ $mail['contract_start'] }}, to {{ $mail['contract_end'] }}.
            <br />
            <br />Please find the complete details of the contract expiry attached
            herewith for your reference.
        </p>

        <strong>Rental Details</strong>
        <table style=" border: solid rgb(42, 41, 41) 1px;     width: 100%;
        text-align: center;">
            <tr style=" border: solid rgb(42, 41, 41) 1px;">
                <th style="   background-color: purple;
        color: white;">#</th>
                <th style="   background-color: purple;
        color: white;">Project</th>
                <th style="   background-color: purple;
        color: white;">Unit No.</th>
                <th style="   background-color: purple;
        color: white;">Rental</th>
                <th style="   background-color: purple;
        color: white;">Markup</th>
                <th style="   background-color: purple;
        color: white;">Deposit</th>
                <th style="   background-color: purple;
        color: white;">Status</th>
            </tr>
            <tr>
                @php
                    $formatter = new NumberFormatter('fil-PH', NumberFormatter::CURRENCY);
                    $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'PHP');

                    // Cast variables to float before formatting
                    $rental = $formatter->formatCurrency((float) $mail['rental']->rental, 'PHP');
                    $markup = '';
                    if ($mail['rental']->markup !== null) {
                        $markup = $formatter->formatCurrency((float) $mail['rental']->markup, 'PHP');
                    }
                    $deposit = $formatter->formatCurrency((float) $mail['rental']->deposit, 'PHP');

                @endphp
                <td></td>
                <td>{{ $mail['rental']->project }}</td>
                <td>{{ $mail['rental']->unit_no }}</td>
                <td id="rental-rental">{{ $rental }}</td>
                <td id="rental-markup">{{ $markup }}</td>
                <td id="rental-deposit">{{ $deposit }}</td>
                <td>{{ $mail['rental']->rent_status }}</td>
            </tr>
        </table>
        @if (count($mail['asso_dues']) > 0)

            <strong>Associate Montly Dues History</strong>
            <table style=" border: solid rgb(42, 41, 41) 1px;     width: 100%;
        text-align: center;">
                <tr style=" border: solid rgb(42, 41, 41) 1px;">
                    <th style="   background-color: purple;
        color: white;">Months</th>
                    <th style="   background-color: purple;
        color: white;">Amount</th>
                    <th style="   background-color: purple;
        color: white;">Status</th>
                </tr>
                @foreach ($mail['asso_dues'] as $dues)
                    @php

                        $formatter = new NumberFormatter('fil-PH', NumberFormatter::CURRENCY);
                        $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'PHP');

                        // Cast variables to float before formatting
                        $total = $formatter->formatCurrency((float) $dues->total, 'PHP');
                        $startd = strtotime($dues->start);
                        $endd = strtotime($dues->end);

                        // Format the timestamp into the desired format
                        $start = date('F j, Y', $startd);
                        $end = date('F j, Y', $endd);
                    @endphp
                    <tr>
                        <td>{{ $start }} - {{ $end }}</td>
                        <td>{{ $total }}</td>
                        <td>{{ $dues->status }}</td>
                    </tr>
                @endforeach

            </table>
        @endif

    </div>
    <script></script>
</body>

</html>
