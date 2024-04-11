<!-- Modal -->
<div class="modal fade" id="create-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i class="fa-solid fa-user-plus"></i>
                    Add User
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-user-form">
                    @csrf
                    <div class="d-flex">
                        <div class="form-floating mb-3 w-100 me create-3">
                            <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">First Name</label>
                        </div>
                        <div class="form-floating mb-3 w-100">
                            <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">Last Name</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
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
