@extends('layout')
@section('title', 'Accounts')
@section('account')
    @php $ent = 'Account' @endphp
    <div class="card rounded-0">
        <div class="card-body ">
            <div class="row">

                <div class="col clearfix">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addModal">Create
                        Account</button>
                    <h2 class='ent'>{{ $ent }}s</h2>


                </div>

            </div>
            <div id="tbl_div">

            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">
                        <i class="fa-solid fa-user mr-1"></i>
                        Add {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" enctype="multipart/form-data">
                        @csrf
                        <div class=" text-center">
                            <img id="previewImage" class="rounded-circle mb-3" src="{{ asset('static/userdefault.png') }}"
                                height="200" alt="">
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" accept="image/*" id="imageInput" name="avatar" class="form-control">
                            <label for="floatingInput">Profile</label>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="form-floating me-3 w-100">
                                <input type="text" name="user_fname" class="form-control">
                                <label for="floatingInput">First Name</label>
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" name="user_lname" class="form-control">
                                <label for="floatingInput">Last Name</label>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="form-floating me-3 w-100">
                                <input type="text" name="email" class="form-control">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating w-100">
                                <input type="number" name="contact" class="form-control">
                                <label for="floatingInput">Contact</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="password" class="form-control">
                            <label for="floatingInput">Password</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" name="role" id="floatingSelect"
                                aria-label="Floating label select example">
                                <option selected>Role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            <label for="floatingSelect">Select Role</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Save</button>
                            <button type="button" class="btn btn-warning px-3 me-2 fw-semibold">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">
                        <i class="fa-solid fa-user mr-1"></i>
                        Edit {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updForm">
                        @csrf
                        <div class=" text-center">
                            <img id="uppreviewImage" class="rounded-circle mb-3"
                                src="{{ asset('static/userdefault.png') }}" height="200" alt="">
                        </div>
                        <input type="hidden" name="user_id">
                        <div class="form-floating mb-3">
                            <input type="file" accept="image/*" id="upimageInput" name="avatar"
                                class="form-control">
                            <label for="floatingInput">Profile</label>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="form-floating me-3 w-100">
                                <input type="text" name="user_fname" class="form-control">
                                <label for="floatingInput">First Name</label>
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" name="user_lname" class="form-control">
                                <label for="floatingInput">Last Name</label>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="form-floating me-3 w-100">
                                <input type="text" name="email" class="form-control">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating w-100">
                                <input type="number" name="contact" class="form-control">
                                <label for="floatingInput">Contact</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="password" class="form-control">
                            <label for="floatingInput">Password</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Save</button>
                            <button type="button" class="btn btn-warning px-3 me-2 fw-semibold">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">
                        <i class="fa-solid fa-user mr-1"></i>
                        Delete {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-3">Are you sure you want to delete this {{ $ent }}?</h5>
                    <form id="delForm">
                        <input type="hidden" name="target" class="form-control">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Yes</button>
                            <button type="button" class="btn btn-danger px-3 me-2 fw-semibold"
                                data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/account.js') }}"></script>
@endsection
