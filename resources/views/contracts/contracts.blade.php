@extends('layout')
@section('title', 'Contracts')
@section('contracts')
    @php $ent = 'Contract' @endphp

    <div class="row border-bottom mb-3 px-3">
        <div class="col mb-2 ">
            <p class="h3">
                <span class="text-primary">
                    <i class="fa-solid fa-file-contract me-4"></i>
                </span>
                <span class='ent'>{{ $ent }}s</span>
            </p>
        </div>
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary mb-3 p-2 me-3" data-bs-target="#addModal" data-bs-toggle="modal">
                <i class="fa-solid fa-plus"></i>
                Add {{ $ent }}
            </button>
            <button class="btn btn-primary mb-3 p-2 me-3" type="button" id="exportFile">
                <i class="fa-solid fa-file-export"></i>
                Export {{ $ent }}
            </button>
            <button class="btn btn-primary mb-3 p-2" data-bs-target="#importModal" data-bs-toggle="modal">
                <i class="fa-solid fa-file-import"></i>
                Import {{ $ent }}
            </button>
        </div>
        <div class="col-12 overflow-auto" id="tbl_div">

        </div>
    </div>
    <div class="row mb-2 px-3">
        <div class="col-xxl-12" id='locations'>

        </div>
    </div>

    <div class="modal fade" id="addModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">
                        <i class="fa-solid fa-user mr-1"></i>
                        Add {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-select" name="location">
                                        <option selected>Choose Unit Type</option>
                                        <option>BACOOR</option>
                                        <option>MAKATI</option>
                                        <option>MANDALUYONG</option>
                                        <option>PASAY</option>
                                        <option>BGC</option>
                                        <option>PASIG</option>
                                        <option>PARANAQUE</option>
                                        <option>QC</option>
                                    </select>
                                    <label for="">Location</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="client" class="form-control">
                                    <label for="">Client</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="property_details" class="form-control">
                                    <label for="">Property Details</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="coordinator" class="form-control">
                                    <label for="">Coordinator</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="contact" class="form-control">
                                    <label for="">Contact Number</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" name="agent" class="form-control">
                                    <label for="">Agent</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="contract_start" class="form-control">
                                    <label for="">Contract Start</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="contract_end" class="form-control">
                                    <label for="">Contract End</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="payment_term" class="form-control">
                                    <label for="">Payment Term</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="tenant_price" class="form-control">
                                    <label for="">Tenant Price</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="owner_income" class="form-control">
                                    <label for="">Owner Income</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="company_income" class="form-control">
                                    <label for="">ABIC Income</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="payment_date" class="form-control">
                                    <label for="">Payment Date</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="due_date" class="form-control">
                                    <label for="">Due Date</label>
                                </div>
                            </div>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
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
                        <input type="hidden" name="id" class="form-control">

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-select" name="location">
                                        <option selected>Choose Unit Type</option>
                                        <option>BACOOR</option>
                                        <option>MAKATI</option>
                                        <option>MANDALUYONG</option>
                                        <option>PASAY</option>
                                        <option>BGC</option>
                                        <option>PASIG</option>
                                        <option>PARANAQUE</option>
                                        <option>QC</option>
                                    </select>
                                    <label for="">Location</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="client" class="form-control">
                                    <label for="">Client</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="property_details" class="form-control">
                                    <label for="">Property Details</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="coordinator" class="form-control">
                                    <label for="">Coordinator</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="contact" class="form-control">
                                    <label for="">Contact Number</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" name="agent" class="form-control">
                                    <label for="">Agent</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="contract_start" class="form-control">
                                    <label for="">Contract Start</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="contract_end" class="form-control">
                                    <label for="">Contract End</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="payment_term" class="form-control">
                                    <label for="">Payment Term</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="tenant_price" class="form-control">
                                    <label for="">Tenant Price</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="owner_income" class="form-control">
                                    <label for="">Owner Income</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="number" name="company_income" class="form-control">
                                    <label for="">ABIC Income</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" name="payment_date" class="form-control">
                                    <label for="">Payment Date</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" name="due_date" class="form-control">
                                    <label for="">Due Date</label>
                                </div>
                            </div>
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
                        <i class="fa-solid fa-user mr-1"></i>
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
                            <button type="button" class="btn btn-danger px-3 me-2 fw-semibold"
                                data-bs-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="importModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">
                        <i class="fa-solid fa-file-import"></i>
                        Import {{ $ent }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="file-import" enctype="multipart/form-data">
                        @csrf
                        <input type="file" accept=".xlsx, .xls, .ods" name="excel_file">
                        <button class="btn btn-primary float-end" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/contracts.js') }}"></script>
@endsection
