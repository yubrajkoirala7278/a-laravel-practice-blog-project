<!-- ===========Modal to Update User=============== -->
<div class="modal fade" id="editUser" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editUserLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form id="ajaxFormUpdate">
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    {{-- model title --}}
                    <h1 class="modal-title fs-5" id="model-title">Edit User</h1>
                    {{-- close button --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- get the current id on edit --}}
                    <input type="hidden" name="user_id" id="user_id">
                    {{-- name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="update_name" name="name">
                        <span id="nameUpdateError" class="text-danger"></span>
                    </div>
                    {{-- email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="update_email" name="email">
                        <span id="emailUpdateError" class="text-danger"></span>
                    </div>
                    {{-- image --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <span id="imageUpdateError" class="text-danger"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- save btn --}}
                    <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- ======== End of Modal to Create user===============  --}}
