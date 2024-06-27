@extends('blogs::admin.layouts.master')
@section('content')
    {{-- create news --}}
    @include('livewire.admin.news.create')
    {{-- edit news --}}
    @include('livewire.admin.news.edit')
    {{-- end of create news --}}
    <div class="bg-white p-4">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-semibold fs-4 text-success">News</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createNews">
                Add News
            </button>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($news && $news->count())
                    @foreach ($news as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge text-bg-success">Published</span>
                                @else
                                    <span class="badge text-bg-danger">Unpublished</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center" style="gap: 5px">
                                    @foreach ($item->images as $image)
                                        <img src="{{ asset('storage/images/news/' . $image->images) }}"
                                            alt="{{ $image->images }}" style="height: 20px">
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-transparent p-0 me-2" data-bs-toggle="modal"
                                    data-bs-target="#editNews" wire:click="edit({{ $item->id }})">
                                    <i class="fa-solid fa-pencil text-warning fs-5"></i>
                                </button>
                                <button class="btn btn-transparent p-0"
                                    wire:confirm="Are you sure you want to delete this post?"
                                    wire:click="delete({{ $item->id }})"><i
                                        class="fa-solid fa-trash text-danger fs-5"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="12">No news to display</td>
                    </tr>
                @endif
            </tbody>

        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">
        {{ $news->links('livewire.pagination') }}
    </div>
@endsection


@push('script')
    <script>
        // news-created event
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('news-created', (event) => {
                toastify().success(event.title);
                $('#createNews').modal('hide');
                $('#editNews').modal('hide');
            });
            Livewire.on('news-deleted', (event) => {
                toastify().success(event.title);
            });
            Livewire.on('error-message', (event) => {
                toastify().error(event.title);
            });
        });
    </script>
    {{-- generate automatic slug from title --}}
    <script>
        function generateSlug(titleId, slugId) {
            const titleElement = document.getElementById(titleId);
            const slugElement = document.getElementById(slugId);

            const titleValue = titleElement.value.trim().replace(/\s+/g, " ");
            const slugValue = titleValue.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');

            slugElement.value = slugValue;
            slugElement.innerHTML = slugValue;
        }
    </script>
@endpush
