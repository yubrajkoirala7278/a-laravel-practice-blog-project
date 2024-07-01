@extends('blogs::admin.layouts.master')

@section('page-name')
    Users
@endsection

@section('content')
    {{-- create user --}}
    @include('blogs::admin.users.create')
    {{-- edit user --}}
    @include('blogs::admin.users.edit')

    <div class="bg-white p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="fw-semibold fs-4 text-success">Users</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUser" id="addButton">
                Add User
            </button>
        </div>
        {{-- =========DISPLAY Users================= --}}
        <table id="users-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        {{-- =========END OF DISPLAY Users=============== --}}
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // =====setup csrf token======
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // =====Reset form============
            $('#addButton').click(function() {
                $('#ajaxForm')[0].reset();
            });

            // =============Call function when MODAL CLOSED for CREATE FORM============//
            $('#addUser').on('hidden.bs.modal', function() {
                // setting empty text on error message
                $('#nameError').html('');
                $('#emailError').html('');
                $('#passwordError').html('');
                $('#confirm_passwordError').html('');
            });


            // ========ADDING DATA TO DB(POST)=============//
            var createFormData = $('#ajaxForm')[0];
            $('#saveBtn').click(function() {

                // setting empty text on error message
                $('#nameError').html('');
                $('#emailError').html('');
                $('#passwordError').html('');
                $('#confirm_passwordError').html('');
                // getting form data
                var formData = new FormData(createFormData);
                // console.log(formData);
                $.ajax({
                    url: "{{ route('users.store') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {
                        // reload the latest row after added
                        table.draw();
                        // hide model if success
                        $('#addUser').modal('hide');
                        // clear form after successfully submitting
                        $('#ajaxForm')[0].reset();
                        // display success message if form submitted successfully
                        toastify().success(response.success);
                    },
                    error: function(error) {
                        // display error message in toastify
                        // toastify().success(error.responseJSON.error);
                        let errorMessage = error.responseJSON.errors;
                        // displaying error message below input field
                        if (errorMessage.name) {
                            $('#nameError').html(errorMessage.name[0]);
                        }
                        if (errorMessage.email) {
                            $('#emailError').html(errorMessage.email[0]);
                        }
                        if (errorMessage.password) {
                            $('#passwordError').html(errorMessage.password[0]);
                        }
                        if (errorMessage.confirm_password) {
                            $('#confirm_passwordError').html(errorMessage.confirm_password[0]);
                        }
                    }
                });
            });
            // ======================================================//


            // ===========READ DATA FROM DB(READ)====================//
            var table = $('#users-table').DataTable({
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "ordering": false,
                searchDelay: 3000,
                "ajax": {
                    url: "{{ route('users.index') }}",
                    type: 'GET',
                    dataType: 'JSON'
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                "lengthMenu": [
                    [5, 20, 50, -1],
                    [5, 20, 50, "All"]
                ],
                "pagingType": "simple_numbers"
            });


            // ===================================================================//


            // ============Fill Current Data to form while UPDATION================//
            var id = '';
            $('body').on('click', '.editButton', function() {
                // get form id
                id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url: '{{ url('admin/users', '') }}' + '/' + id + '/edit',
                    method: 'GET',
                    success: function(response) {
                        // console.log(response);
                        // display model
                        $('#editUser').modal('show');
                        // fill current data on form
                        $('#update_name').val(response.name);
                        $('#update_email').val(response.email);
                        // inserted current id value in form
                        $('#user_id').val(response.id);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            });
            // =============================================================//

            // =====UPDATING User TO DB(UPDATE/PUT)===========================//
            var updateFormData = $('#ajaxFormUpdate')[0];
            $('#updateBtn').click(function() {
                console.log(id);
                // setting empty text on error message
                $('#nameUpdateError').html('');
                $('#emailUpdateError').html('');
                // getting form data
                var formUpdateData = new FormData(updateFormData);
                // console.log(formData);
                $.ajax({
                    url: "/admin/users/" + id,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formUpdateData,

                    success: function(response) {
                        // reload the latest row after added
                        table.draw();
                        //    hide model if success
                        $('#editUser').modal('hide');

                        // clear form after successfully submitting
                        $('#ajaxFormUpdate')[0].reset();

                        // display success message if form submitted
                        toastify().success(response.success);
                    },
                    error: function(error) {
                        // console.log(error);
                        let errorMessage = error.responseJSON.errors;
                        // console.log(errorMessage);

                        // displaying error message
                        if (errorMessage.name) {
                            $('#nameUpdateError').html(errorMessage.name[0]);

                        }
                        if (errorMessage.email) {
                            $('#emailUpdateError').html(errorMessage.email[0]);
                        }
                    }
                });
            });
            // ======================================================================//


             // ================DELETE User==============================//
         $('body').on('click', '.delButton', function() {
                let id = $(this).data('id');
                if (confirm('Are you sure you want to delete it')) {
                    $.ajax({
                        url: '{{ url('admin/users/', '') }}' + '/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            // refresh the table after delete
                            table.draw();
                            // display the delete success message
                            toastify().success(response.success);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        // =====================================================================//

         // ===========Call function when MODAL CLOSED for UPDATE FORM=========//
         $('#editUser').on('hidden.bs.modal', function() {
            // setting empty text on error message
            $('#nameUpdateError').html('');
            $('#emailUpdateError').html('');
        });


        // ================DELETE BLOG==============================//

        });
    </script>
@endpush
