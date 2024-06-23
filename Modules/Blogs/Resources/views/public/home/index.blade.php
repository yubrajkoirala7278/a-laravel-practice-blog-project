<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let debounceTimeout;

            function fetchBlogs(page = 1, search = '') {
                $.ajax({
                    url: '{{ route('home') }}',
                    data: {
                        page: page,
                        search: search,
                        action:'searchBlogs',
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
        });
    </script>
</body>

</html>
