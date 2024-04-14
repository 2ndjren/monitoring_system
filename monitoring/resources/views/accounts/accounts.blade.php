@extends('layout')
@section('title', 'Monitoring | Accounts')
@section('accounts')
    <div class="">
        <div class="row border-bottom">
            <div class="col-6">
                <p class="h3"><span class="text-primary"><i class="fa-solid fa-users-gear me-4"></i></span>Accounts</p>

            </div>
            <div class="col-6">

                <div class="dropdown float-end">
                    <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><button id="create-user-btn" class="dropdown-item btn text-primary    "><span><i
                                        class="fa-solid fa-user-plus"></i></span>
                                Create Account</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="accounts-container" class="row">
            </div>

        </div>
    </div>
    @include('accounts.modals.modals')
    <script src="{{ asset('js/accounts.js') }}"></script>
    <script>
        $(document).ready(function() {
            AccountsEvents()
            Create_User()
            Accounts()
        });
    </script>
@endsection
