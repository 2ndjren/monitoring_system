<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a051b84b57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
</head>

<body>

    {{-- <button onclick="notifyMe()">Notify me!</button> --}}

    <div id="login" class="row p-5">
        <div class="col-lg-4 col-0 p-3">

        </div>
        <div class="col-lg-4 col-sm-12 p-3 shadow-sm ">
            <p class="text-center">ABIC REALTY & CONSULTANCY CORPORATION</p>
            <p class="text-center">MONITORING SYSTEM</p>

            <form id="login-account-form" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="floatingInput" autocomplete="off"
                        placeholder="name@example.com">
                    <label>Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingInput" autocomplete="off"
                        placeholder="name@example.com">
                    <label>Password</label>
                </div>
                <span id="forgot-account-btn" class="">Forgot Account?</span>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5">Login</button>
                </div>
            </form>

        </div>
        <div class="col-lg-4 col-0 p-3">

        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toast-message" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong id="toast-text-color" class="me-auto ">
                    <i id="toast-icon-success" class="fa-solid fa-circle-check me-3  d-none"></i>
                    <i id="toast-icon-failed" class="fa-solid fa-circle-xmark me-3 d-none"></i>
                    <span id="toast-header-text"></span>
                </strong>
                <button type="button" id=clearModal class="btn-close" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>



<script>
    $(document).ready(function() {
        // showNotification()
        Login()
    });
</script>

</html>
