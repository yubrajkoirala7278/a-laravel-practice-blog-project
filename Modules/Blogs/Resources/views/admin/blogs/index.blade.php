@extends('blogs::admin.layouts.master')
@section('page-name')
    Blogs
@endsection
@section('content')
    <div class="p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success fw-semibold fs-4">Blogs</h2>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">Add Blogs</a>
        </div>

        {{-- =========DISPLAY BLOGS================= --}}
        <div class="mt-4">
            <table id="blog-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- =========END OF DISPLAY BLOGS=============== --}}
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
            // ==========================


            // ===========READ DATA FROM DB(READ)====================//
            var table = $('#blog-table').DataTable({
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "ordering": false,
                searchDelay: 3000,
                "ajax": {
                    url: "{{ route('admin.blog') }}",
                    type: 'GET',
                    dataType: 'JSON'
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row, meta) {
                            var tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data;
                            var plainText = tempDiv.innerText || tempDiv.textContent;
                            // Limit to 30 characters
                            if (plainText.length > 30) {
                                plainText = plainText.substring(0, 30) + '...';
                            }
                            return plainText;
                        }
                    },
                    {
                        data: "image",
                        name: "image",
                        "render": function(data, type, full, meta) {
                            return '<img src="{{ asset('storage/images/blogs/') }}/' + data +
                                '" alt="Image" style="height:20px">';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                "pagingType": "simple_numbers"
            });
            // ===================================================================//

            // ================DELETE BLOG==============================//
            $('body').on('click', '.delButton', function() {
                let slug = $(this).data('slug');
                if (confirm('Are you sure you want to delete it')) {
                    $.ajax({
                        url: '{{ url('admin/blog/destroy', '') }}' + '/' + slug,
                        method: 'DELETE',
                        success: function(response) {
                            // refresh the table after delete
                            table.draw();
                            console.log(response.success);
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


        });
    </script>
@endpush
