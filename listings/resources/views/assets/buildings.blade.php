@extends('layout')
@section('title', 'Projects')

@section('buildings')
    @php $ent = 'Building' @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="" href="{{ url('/projects') }}">Projects</a></li>
            <li class="breadcrumb-item active"><a class="text-secondary" id="buildings"
                    href="{{ url('/buildings') }}">Buildings</a></li>
        </ol>
    </nav>
    <div class="card rounded-0">
        <div class="card-body ">
            <div class="row">
                <div class="col">
                    <h2 class="ent">{{ $ent }}s</h2>
                </div>
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary mb-3 p-2" data-bs-target="#addModal" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i>
                        Add {{ $ent }}
                    </button>
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
                        <i class="fa-solid fa-building mr-1"></i>
                        Add {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <input type="hidden" name="projects_id">
                        <div class="form-floating mb-3">
                            <input type="text" name="building_name" class="form-control">
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="street" class="form-control">
                            <label for="floatingInput">Street</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="barangay" class="form-control">
                            <label for="floatingInput">Barangay</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="city" class="form-control">
                            <label for="floatingInput">City</label>
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
                        <i class="fa-solid fa-building mr-1"></i>
                        Edit {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updForm">
                        <input type="hidden" name="id" class="form-control">
                        <div class="form-floating mb-3">
                            <input type="text" name="building_name" class="form-control">
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="street" class="form-control">
                            <label for="floatingInput">Street</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="barangay" class="form-control">
                            <label for="floatingInput">Barangay</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="city" class="form-control">
                            <label for="floatingInput">City</label>
                        </div>



                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Update</button>
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
                        <i class="fa-solid fa-building mr-1"></i>
                        Delete {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-3">Are you sure you want to delete this {{ $ent }}?</h5>
                    <form id="delForm">
                        <input type="hidden" name="id" class="form-control">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Yes</button>
                            <button type="button" class="btn btn-danger px-3 me-2 fw-semibold">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/buildings.js') }}"></script>
@endsection
