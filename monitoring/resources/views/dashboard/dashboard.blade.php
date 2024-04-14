@extends('layout')
@section('title', 'Monitoring | Dashboard')
@section('dashboard')
    <div class=" ">
        <div class=" row border-bottom">
            <p class="h3"><span class="text-primary"><i class="fa-solid fa-chart-simple me-4"></i></span>Analytics
                Dashboard</p>
        </div>

        <div class="row mt-1">
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
                                <span>Unit Owners</span><br>
                                <h4 class="dash-loader" class="dash-loader" id="unit-owners-count">0</h4>
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
                                <span>Projects</span> <br>
                                <h4 class="dash-loader" id="projects-count">0</h4>
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
                                <span>Units</span><br>
                                <h4 class="dash-loader" id="units-count">0</h4>
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
                                <span>Available Units</span><br>
                                <h4 class="dash-loader" id="available-units-count">0</h4>
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
                                <span>Occupied Units</span><br>
                                <h4 class="dash-loader" id="occupied-units-count">0</h4>
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
                                <small>Unpaid Monthly Dues</small><br>
                                <h4 class="dash-loader" id="unpaid-monthly-dues-count">0</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card rounded-0 ">
                    <div class="card-body p-2 ">
                        <div class="row border-bottom">
                            <div class="col-2  d-flex justify-content-center">
                                <h4 class="text-primary "><i class="fa-solid fa-building"></i></i></h4>
                            </div>
                            <div class="col-10 px-3">
                                <p class="text-primary">Projects Units </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="units_per_projects" class="w-100" style="height:450px"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-0 ">
                    <div class="card-body p-2 ">
                        <div class="row border-bottom">
                            <div class="col-2  d-flex justify-content-center">
                                <h4 class="text-primary "><i class="fa-solid fa-building"></i></i></h4>
                            </div>
                            <div class="col-10 px-3">
                                <p class="text-primary">Ownership </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="ownership" class="w-100" style="height:450px"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card rounded-0 ">
                    <div class="card-body p-2 ">
                        <div class="row">
                            <div class="col-3  d-flex justify-content-center">
                                <h4 class="text-primary "><i class="fa-solid fa-user-shield"></i></h4>
                            </div>
                            <div class="col-9">
                                <p class="text-primary">Accounts</p>
                            </div>
                        </div>
                        <div id="accounts-data" class="row border-top">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.modals.modals')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
