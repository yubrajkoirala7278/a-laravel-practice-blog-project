<!-- ===========Modal to Create User=============== -->
<div class="modal fade" id="addUser" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addUserLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form id="ajaxForm">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- model title --}}
                    <h1 class="modal-title fs-5" id="model-title">Add User</h1>
                    {{-- close button --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <span id="nameError" class="text-danger"></span>
                    </div>
                    {{-- email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <span id="emailError" class="text-danger"></span>
                    </div>
                    {{-- password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <span id="passwordError" class="text-danger"></span>
                    </div>
                    {{-- confirm_password --}}
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <span id="confirm_passwordError" class="text-danger"></span>
                    </div>
                    {{-- image --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Profile</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <span id="imageError" class="text-danger"></span>
                    </div>

                    {{-- role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="select-role" data-placeholder="Choose Role" name="role">
                            <option selected disabled>Choose Role</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- save btn --}}
                    <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- ======== End of Modal to Create User===============  --}}
