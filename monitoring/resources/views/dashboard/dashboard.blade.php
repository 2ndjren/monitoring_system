@extends('layout')
@section('title', 'Monitoring | Dashboard')
@section('dashboard')
    <div class="container-fluid">
        <p class="h3"><span><i class="fa-solid fa-chart-simple me-4"></i></span>Analytics Dashboard</p>
    </div>
    <div class="row">
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3  d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-solid fa-users"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <span>Unit Owners</span>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-solid fa-building"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <span>Projects</span>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-solid fa-house-user"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <span>Units</span>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-solid fa-house-circle-check"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <span>Available Units</span>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-solid fa-house-circle-xmark"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <span>Occupied Units</span>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card rounded-0 ">
                <div class="card-body p-2 ">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center border-dark border-end">
                            <h3 class="text-primary">
                                <i class="fa-regular fa-calendar-days"></i>
                            </h3>
                        </div>
                        <div class="col-9">
                            <small>Unpaid Monthly Dues</small>
                            <h4>10</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="row"></div>

    @include('dashboard.modals.modals')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
