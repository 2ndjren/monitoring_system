@extends('layout')
@section('title', 'Dashboard')
@section('dashboard')
    <div class="card rounded-0">
        <div class="card-body ">
            <div class=" row border-bottom">
                <p class="h3">
                    <span class="text-primary">
                        <i class="fa-solid fa-chart-simple me-4"></i>
                    </span>
                    Analytics Dashboard
                </p>
            </div>


            <div class="row mt-2">

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
                                    <span>Clients</span><br>
                                    <h4 class="dash-loader" id="counts-clients">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <span>Coordinators</span><br>
                                    <h4 class="dash-loader" id="counts-coordinators">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <span>Agents</span><br>
                                    <h4 class="dash-loader" id="counts-agents">0</h4>
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
                                    <span>Properties</span> <br>
                                    <h4 class="dash-loader" id="counts-properties">0</h4>
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
                                    <h4 class="dash-loader" id="counts-units">0</h4>
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
                                        <i class="fa-solid fa-file-contract"></i>
                                    </h3>
                                </div>
                                <div class="col-9">
                                    <span>Contracts</span><br>
                                    <h4 class="dash-loader" id="counts-contracts">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-lg-8 col-sm-6">
                    <p class="text-primary fw-bold text-center"> <span class="me-2"><i
                                class="fa-solid fa-users"></i></span>
                        Client
                        Units</p>
                    <div class="card rounded-0 ">
                        <div class="card-body p-2 ">

                            <canvas id="dash1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <p class="text-primary fw-bold text-center"> <span class="me-2"><i
                                class="fa-solid fa-users"></i></span>
                        Contract Dues Indicator</p>
                    <div class="card rounded-0 ">
                        <div class="card-body p-2 ">
                            <canvas id="dash2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <p class="text-primary fw-bold text-center"> <span class="me-2"><i
                                class="fa-solid fa-users"></i></span>
                        Contract Expiration Indicator
                    </p>
                    <div class="card rounded-0 ">
                        <div class="card-body p-2 ">
                            <canvas id="dash3"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

@endsection
