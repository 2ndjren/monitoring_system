@extends('layout')
@section('title', 'Monitoring | Owner | Data')
<link rel="stylesheet" href="{{ asset('css/unit_owners.css') }}">
@section('view_owner_data')
    <div class="" id="unit-owner-property-details">
        <div class="">

            <div class="clearfix  border-2 border-bottom  mb-3 ">
                <p class="h3 float-start"><span class="text-primary"><i class="fa-solid fa-user me-2 me-3"></i></span><span
                        id="owner-name"></span>
                    Properties</p>
                <div id="units-menu-btn" class="dropdown float-end">
                    <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a id="create-unit-btn" class="dropdown-item" href="#">Add Units</a></li>
                    </ul>
                </div>
                <div id="units-data-menu-btn" class="dropdown float-end d-none">
                    <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a id="create-rental-details-btn" class="dropdown-item" href="#">Add Rental Data</a></li>
                        <li><a id="create-monthly-dues-btn" class="dropdown-item" href="#">Add Monthly Dues Data</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="owner-properties-container">
                <div class="row" id="units-data-container">

                </div>
                <div class="d-none w-100" id="unit-details-data">
                    <span id="exit-unit-details">Exit</span>
                    <div class="w-100">
                        <p>Current Transaction</p>
                        <div id="current-transaction" class=" row w-100 overflow-auto">

                        </div>
                    </div>
                    <div class="" id='transactions'>
                        <p>Recent Transactions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('unit_owners.modals.modal')
    <script src="{{ asset('js/view_owner_details.js') }}"></script>
    <script>
        $(document).ready(function() {
            View_Owners_Events()
            Display_Info()
            Create_Unit()
            Create_Unit_Rentals()
            Create_Asso_Dues()
            var owner = JSON.parse(localStorage.getItem("owner_data"));
            ViewUnitsOnly()

            $("input[name=owner_id]").val(owner.id);
            // $("input[name=owner_id]").val(owner.id);
            // $('#create-rental-details-btn').attr('data-id')
        });
    </script>
@endsection
