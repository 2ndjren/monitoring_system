@extends('layout')
@section('title', 'Monitoring | Unit Owners')
<link rel="stylesheet" href="{{ asset('css/unit_owners.css') }}">
@section('unit_owners')
    <div class=" row border-bottom">
        <div class="col-6 text-start">
            <p class="h3"><span class="text-primary"><i class="fa-solid fa-users me-4"></i></span>Unit Owners</p>
        </div>
        <div class="col-6 text-end">
            <div class="d-flex justify-content-end align-items-center">
                <div id="search-unit-owner" class=" me-3">
                    <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Search">

                </div>
                <div class="text-center">
                    <span class="fw-semibold text-primary me-lg-3 p-2" id="sort-text"></span>
                    <span data-value="asc" class="sort-unit-owners  p-2"><i class="fa-solid fa-arrow-up"></i></span>
                    <span data-value="desc" class="sort-unit-owners  me-3 p-2"><i
                            class="fa-solid fa-arrow-down "></i></span>
                </div>
                <div class="dropdown">
                    <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a id="create-unit-owner-btn" class="dropdown-item" href="#">Add Unit Owner</a></li>
                        <li><a id="delete-unit-owner-btn" class="dropdown-item" href="#">Delete Unit Owner</a></li>
                        <li><a id="generate-report-btn" class="dropdown-item" href="#">Generate Report</a></li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

    <div class="container-fluid clearfix">
        <div id="unit-owner-list-data" class="row">


        </div>
    </div>
    @include('unit_owners.modals.modal')
    <script src="{{ asset('js/unit_owners.js') }}"></script>
    <script>
        $(document).ready(function() {
            UnitOwnersEvent()
            Asc()
            Search()
        });
    </script>
@endsection
