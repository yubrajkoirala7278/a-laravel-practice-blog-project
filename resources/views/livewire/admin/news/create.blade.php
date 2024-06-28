<!-- Create News -->
<div  wire:ignore.self class="modal fade"  id="createNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createNewsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createNewsLabel">Add News</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  wire:click="resetFields()"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" wire:model="title" oninput="generateSlug('title', 'slug')">
                        @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" wire:model="slug">
                        @error('slug') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" multiple wire:model="images">
                        @error('images') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3" wire:ignore>
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="news-content" placeholder="Enter the Description" rows="5" wire:model="description"></textarea>
                        @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <div class="d-flex align-items-center" style="gap: 10px">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                id="publish" wire:model="status" value="1" {{ $status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="publish">
                                    Publish
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                id="unpublish" wire:model="status" value="0" {{ $status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="unpublish" >
                                    Draft
                                </label>
                            </div>
                        </div>
                        @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  wire:click="resetFields()">Close</button>
                <button type="button" class="btn btn-success" wire:click.prevent="store()">Submit</button>
            </div>
        </div>
    </div>
</div>
