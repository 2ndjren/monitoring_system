<div style="width: 50vw; height:100vh;">
    <div class=""
        style="width:50%; margin-left:auto;margin-right:auto; background:linear-gradient(to right, rgb(192, 10, 119),rgb(255, 16, 16)); padding:20px">
        <h4 style="color:white; text-align:center">Contract Completed</h4>
        <h6 style="text-align:center; color:white">Property Details</h6>
        <p style="color:white">Property : {{ $mail['property'] }}</p>
        <p style="color:white">Contract Start : {{ $mail['start'] }}</p>
        <p style="color:white">Contract End : {{ $mail['end'] }}</p>
        <p style="color:white">Status : {{ $mail['status'] }}</p>
        <a href="" style="text-align: center; color:white; background:rgb(7, 158, 17); padding:5px;">View
            Contract
            Details</a>
    </div>
</div>
