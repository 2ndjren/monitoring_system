<!-- Modal -->
<div class="modal fade" id="unit-owner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i class="fa-solid fa-user-plus"></i>
                    Add Unit
                    Owner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-unit-owner-form">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Name</label>
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

<div class="modal fade" id="delete-unit-owner-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel"><i class="fa-solid fa-user-minus"></i>
                    Delete Unit
                    Owner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-unit-owner-form">
                    @csrf
                    <div class="form-floating">
                        <select class="form-select todelete-owners" id="floatingSelect"
                            aria-label="Floating label select example">
                        </select>
                        <label for="floatingSelect">Works with selects</label>
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

{{-- Create Unit Modal  --}}
<div class="modal fade" id="create-owner-units" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i
                        class="fa-solid fa-building-un"></i>
                    Add Unit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-unit-form">
                    @csrf
                    <input type="hidden" name="owner_id">
                    <div class="form-floating mb-3">
                        <input type="text" name="project" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Project</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="unit_no" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Unit No.</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="status" id="floatingSelect"
                            aria-label="Floating label select example">
                            {{-- <option selected>Choose</option> --}}
                            <option value="">Choose</option>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                        </select>
                        <label for="floatingSelect">Status</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Save</button>
                        <button type="button" class="btn btn-warning px-3 me-2 fw-semibold clearModal">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




{{-- Create rent details Modal  --}}
<div class="modal fade" id="create-rental-details-modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i
                        class="fa-solid fa-building-un"></i>
                    Create </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-unit-rental-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="u_no">
                    <div class="form-floating mb-3">
                        <input type="number" name="rental" class="form-control" id="floatingInput"
                            placeholder="">
                        <label for="floatingInput">Rental</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="markup" class="form-control" id="floatingInput"
                            placeholder="">
                        <label for="floatingInput">Markup</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="deposit" class="form-control" id="floatingInput"
                            placeholder="">
                        <label for="floatingInput">Deposit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="contract_start" class="form-control" id="floatingInput"
                            placeholder="">
                        <label for="floatingInput">Contract Started</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="contract_end" class="form-control" id="floatingInput"
                            placeholder="">
                        <label for="floatingInput">Contract Ended</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-3 me-2 fw-semibold">Save</button>
                        <button type="button" class="btn btn-warning px-3 me-2 fw-semibold clearModal">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>