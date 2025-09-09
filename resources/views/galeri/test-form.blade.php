@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Test Gallery Form</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Basic Gallery Info --}}
                        <div class="form-group mb-3">
                            <label for="nama_galeri">Nama Galeri</label>
                            <input type="text" class="form-control" name="nama_galeri" value="Test Gallery" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi_galeri">Deskripsi</label>
                            <textarea name="deskripsi_galeri" class="form-control">Test description</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        {{-- Gallery Item 1 --}}
                        <h5>Gallery Item 1</h5>
                        <div class="form-group mb-3">
                            <label>Type</label>
                            <select name="gallery_items[0][type]" class="form-control" required>
                                <option value="image">Image</option>
                                <option value="youtube">YouTube</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Sequence</label>
                            <input type="number" name="gallery_items[0][sequence]" class="form-control" value="1">
                        </div>

                        <div class="form-group mb-3">
                            <label>Image File</label>
                            <input type="file" name="gallery_items[0][file]" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label>YouTube URL (jika type youtube)</label>
                            <input type="url" name="gallery_items[0][youtube_url]" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        {{-- Hidden fields --}}
                        <input type="hidden" name="gallery_items_exist" value="1">

                        <button type="submit" class="btn btn-primary">Submit Test</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple debug
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form data being submitted:', new FormData(this));
            
            // Log all form inputs
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key, ':', value);
            }
        });
    </script>
@endsection
