@extends('layout')
@section('title', 'Monitoring | Settings')
<link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@section('settings')
    <div class="">
        <div class="row border-bottom mb-1">
            <p class="h3"><span>
                    <span class="text-primary"><i class="fa-solid fa-gear "></i></span>
                </span>Settings</p>
        </div>
        <div class="row mb-3">
            <div class="col-3 me-3 border-end border-5 pe-5">
                <div id='account-btn' class="col-lg-12 col-sm-12 text-center p-3 border border-1 active-setting-option setting-option">
                    <h3><i class="fa-solid fa-user"></i></h3>
                    <strong>Account</strong>

                </div>
                <div id='changelog-btn' class="col-lg-12 col-sm-12 text-center p-3 border border-1 setting-option">
                    <h3><i class="fa-solid fa-clock-rotate-left"></i></h3>
                    <strong>Changelog</strong>

                </div>
                <div id="logout-btn" class="col-lg-12 col-sm-12 text-center p-3 border border-1 setting-option ">
                    <h3><i class="fa-solid fa-power-off"></i></h3>
                    <strong>Logout</strong>
                </div>
            </div>
            <div class="col-8">
                <div id="account-content-data" class="account-content p">

                </div>
                <div id="changelog-content-data" class="changelog-content p d-none">

                </div>
            </div>
        </div>

    </div>
    @include('settings.modals.modals')
    <script src="{{ asset('js/setting.js') }}"></script>
    <script>
        $(document).ready(function() {
            Setting_Events()
            UpdateProfile()
            AccountInformation();
        });
    </script>
@endsection
