@extends('blogs::public.layouts.master')
@section('content')
{{-- =========Blogs Section============ --}}
<div class="container mt-5">
    <h2 class="text-success fw-semibold mb-3 text-center">Blogs</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="searchTitleSlug" class="form-control" placeholder="Search by Title or Slug">
        </div>
    </div>
    <div class="row" id="blogCardsContainer">
        <!-- Blog cards will be appended here -->
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Pagination links will be appended here -->
                </ul>
            </nav>
        </div>
    </div>
</div>
{{-- ===========end of blogs Section============== --}}

{{-- ===========contact us section================= --}}
<div class="container">
    <h2 class="text-success fw-semibold mb-3 text-center">Contact Us</h2>
    <form id="contactForm">
        @csrf
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label>Subject:</label>
            <input type="text" class="form-control" name="subject" required>
        </div>
        <div class="form-group">
            <label>Message:</label>
            <textarea class="form-control" name="message" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
{{-- ==========end of contact us section=========== --}}
@endsection

@push('script')
<script>
    $(document).ready(function() {
            // ==========display blogs and search without page load=========
            let debounceTimeout;

            function fetchBlogs(page = 1, search = '') {
                $.ajax({
                    url: '{{ route('home') }}',
                    data: {
                        page: page,
                        search: search,
                        action: 'searchBlogs',
                    },
                    success: function(data) {
                        $('#blogCardsContainer').empty();
                        data.data.forEach(blog => {
                            let blogCard = `
                         <div class="col-md-4 mb-3">
                             <div class="card">
                                 <img src="{{ asset('storage/images/blogs') }}/${blog.image}" class="card-img-top" alt="No image" style="height:250px">
                                 <div class="card-body">
                                     <h5 class="card-title">${blog.title}</h5>
                                     <p class="card-text">${blog.description.length > 30 ? blog.description.substring(0, 30) + '...' : blog.description}</p>
                                 </div>
                             </div>
                         </div>
                     `;
                            $('#blogCardsContainer').append(blogCard);
                        });

                        $('#pagination').empty();
                        for (let i = 1; i <= data.last_page; i++) {
                            let pageLink =
                                `<li class="page-item ${i === data.current_page ? 'active' : ''}"><a class="page-link" href="#">${i}</a></li>`;
                            $('#pagination').append(pageLink);
                        }
                    }
                });
            }

            fetchBlogs();

            function debounce(func, delay) {
                return function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => func.apply(this, arguments), delay);
                };
            }

            $('#searchTitleSlug').on('keyup', debounce(function() {
                let search = $(this).val();
                fetchBlogs(1, search);
            }, 2000));

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).text();
                let search = $('#searchTitleSlug').val();
                fetchBlogs(page, search);
            });
            // =========end of display blogs and search without page load=====

            // ===========contact us form==================
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('contact.submit') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        toastify().success(response.success);
                        $('#contactForm')[0].reset();
                        $('button[type="submit"]').prop('disabled', false);
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
            });
            // =========end of contact us form=============
        });
</script>
@endpush