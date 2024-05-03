@extends('layout')
@section('notification')
    <h3>Notification</h3>
    <div class=" px-3">
        <div class="row" id="notification-container">

        </div>
        <button onclick="notifyMe()">Notify me!</button>

    </div>
    <script>
        $(document).ready(function() {
            // Notify();
            // Push_Notification()
        });
    </script>

    <script src="{{ asset('js/notification.js') }}"></script>
@endsection
