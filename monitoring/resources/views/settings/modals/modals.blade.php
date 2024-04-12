<!-- Modal -->
<div class="modal fade" id="edit-account-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="unit-ownerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i class="fa-solid fa-user-plus"></i>
                    Edit Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="update-user-profile-form">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="hidden" name="user_id">
                        <input type="text" name="fname" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="lname" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="email" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Email</label>
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
