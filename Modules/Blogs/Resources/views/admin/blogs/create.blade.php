@extends('blogs::admin.layouts.master')
@section('page-name')
    Blogs
@endsection
@section('content')
    <div class="p-4 bg-white">
        <h3 class="fw-semibold fs-4 text-success">Add Blogs</h3>
        <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" oninput="generateSlug()">
                @error('title')
                    <div class="error text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                @error('slug')
                    <div class="error text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type='file' name='image' class='form-control'
                    accept='image/jpeg , image/jpg, image/gif, image/png,image/webp'>
                @error('image')
                    <div class="error text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="blog-content" placeholder="Enter the Description" rows="5" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="d-flex align-items-center" style="gap: 10px">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="is_published" id="publish"
                            checked @if (old('is_published')) checked @endif>
                        <label class="form-check-label" for="publish">
                            Publish
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="is_published" id="unpublish"
                            @if (old('is_published')) checked @endif>
                        <label class="form-check-label" for="unpublish">
                            Unpublish
                        </label>
                    </div>
                </div>
                @error('status')
                    <div class="error text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection


@push('script')
  {{-- ckeditor --}}
  <script>
    ClassicEditor
        .create(document.querySelector('#blog-content'), {
          removePlugins: [ 'Image','ImageCaption','ImageStyle','ImageToolbar','ImageUpload','Indent','ImageUpload','MediaEmbed'],
        })
        .then(editor => {
            console.log('Available plugins:', ClassicEditor.builtinPlugins.map(plugin => plugin.pluginName));
        })
        .catch(error => {
            console.error(error.stack);
        });
</script>
@endpush

