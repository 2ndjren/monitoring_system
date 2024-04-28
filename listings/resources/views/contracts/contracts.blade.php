@extends('layout')
@section('title', 'Contracts')
@section('contracts')
    @php $ent = 'Contract' @endphp
    <div class="row">
        <div class="col">
            <h2 class='ent'>{{ $ent }}s</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary mb-3 p-2" data-bs-target="#addModal" data-bs-toggle="modal">
                <i class="fa-solid fa-plus"></i>
                Add {{ $ent }}
            </button>
        </div>
        <div class="col-12 overflow-auto" id="tbl_div">

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

                        <div class="form-floating mb-3">
                            <select class="form-select" name='clients_c_id'></select>
                            <label for="">Client</label>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="form-floating me-3 w-100">
                                <select class="form-select" name='projects_id'></select>
                                <label for="">Project</label>
                            </div>
                            <div class="form-floating me-3 w-100">
                                <select class="form-select" name='buildings_b_id'></select>
                                <label for="">Building</label>
                            </div>
                            <div class="form-floating w-100">
                                <select class="form-select" name='units_u_id'></select>
                                <label for="">Unit</label>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name='coordinators_co_id'>
                            </select>
                            <label for="">Coordinator</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name='agents_a_id'></select>
                            <label for="">Agent</label>
                        </div>

                        <div class="d-flex mb-3 ">

                            <div class="form-floating me-3 w-100">
                                <input type="date" name="contract_start" class="form-control">
                                <label for="">Contract Start</label>
                            </div>
                            <div class="form-floating  w-100">
                                <input type="date" name="contract_end" class="form-control">
                                <label for="">Contract End</label>
                            </div>

                        </div>

                        <div class="d-flex mb-3 ">

                            <div class="form-floating me-3 w-100">
                                <input type="number" name="advance" class="form-control">
                                <label for="">Advance</label>
                            </div>
                            <div class="form-floating me-3  w-100">
                                <input type="number" name="deposit" class="form-control">
                                <label for="">Deposit</label>
                            </div>
                            <div class="form-floating  w-100">
                                <input type="number" name="tenant_price" class="form-control">
                                <label for="">Tenant Price</label>
                            </div>

                        </div>

                        <div class="d-flex mb-3 ">

                            <div class="form-floating  w-100 me-3">
                                <input type="number" name="client_income" class="form-control">
                                <label for="">Owner Income</label>
                            </div>
                            <div class="form-floating me-3 w-100">
                                <input type="number" name="company_income" class="form-control">
                                <label for="">Company Income</label>
                            </div>
                            <div class="form-floating  w-100">
                                <input type="date" class="form-control" name='due_date'>
                                <label for="">Due Date</label>
                            </div>

                        </div>

                        <div class="d-flex mb-3">

                            <div class="form-floating w-100 me-3">
                                <input type="number" name="payment_day" class="form-control">
                                <label for="">Payment Day</label>
                            </div>
                            <div class="form-floating me-3 w-100">
                                <input type="number" name="payment_interval" class="form-control">
                                <label for="">Payment Interval</label>
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
                        <input type="hidden" name="id" class="form-control">

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
                            <button type="button" class="btn btn-danger px-3 me-2 fw-semibold">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/contracts.js') }}"></script>
@endsection
