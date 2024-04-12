@extends('layout')
@section('title', 'Monitoring | Settings')
<link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@section('settings')
    <div class="container-fluid">
        <p class="h3"><span>
                <i class="fa-solid fa-gear me-4"></i>
            </span>Settings</p>
        <div class="row">
            <div class="col-3 me-3 border-end border-5 pe-5">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 text-center p-3 border border-1 active-setting-option setting-option ">
                        <h3><i class="fa-solid fa-user"></i></h3>
                        <strong>Account</strong>

                    </div>
                    <div id="logout-btn" class="col-lg-12 col-sm-12 text-center p-3 border border-1 setting-option ">
                        <h3><i class="fa-solid fa-power-off"></i></h3>
                        <strong>Logout</strong>

                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="account-content">
                    
                </div>
            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
