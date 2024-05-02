<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('static/abic.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark position-fixed" style="height: 100vh; width:100vw ">
    <div class="row h-100">
        <div class="col-lg-4 col-sm-0"></div>
        <div class="col-lg-4 col-sm-12 h-100 p-5">
            <div class="card my-auto mx-auto p-3">
                <div class="card-body ">
                    <div class=" text-center">
                        <img src="{{ asset('static/abic.png') }}" height="200" alt="">
                    </div>
                    <div class="container">
                        <form id="loginForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingInput">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingInput">
                                <label for="floatingInput">Password</label>
                            </div>
                            <div class="text-end">
                                <a href="">Forgot Password?</a>

                            </div>
                            <div class="d-flex mt-3">
                                <button type="submit" class="btn btn-primary fw-semibold w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-0"></div>

    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toasMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toast-header"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span id="toast-content"></span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
