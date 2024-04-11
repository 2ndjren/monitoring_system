@extends('layout')
@section('title', 'Monitoring | Unit Owners')
<link rel="stylesheet" href="{{ asset('css/unit_owners.css') }}">
@section('unit_owners')
    <div class=" row">
        <div class="col-6 text-start">
            <p class="h3 p-3"><span><i class="fa-solid fa-users me-4"></i></span>Unit Owners</p>
        </div>
        <div class="col-6 text-end">
            <div class="dropdown">
                <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a id="create-unit-owner-btn" class="dropdown-item" href="#">Add Unit Owner</a></li>
                    <li><a id="delete-unit-owner-btn" class="dropdown-item" href="#">Delete Unit Owner</a></li>
                </ul>
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-end align-items-center shadow-sm">
        <div id="search-unit-owner" class=" me-3">
            <div class="form-floating mb-2">
                <input type="text" name="name" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Search here...</label>
            </div>
        </div>
        <div class="text-center">
            <span class="fw-semibold text-success h4 me-lg-3 p-2">Sort</span>
            <span data-value="asc" class="sort-unit-owners h4 p-2"><i class="fa-solid fa-arrow-up"></i></span>
            <span data-value="desc" class="sort-unit-owners h4 me-3 p-2"><i class="fa-solid fa-arrow-down "></i></span>
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