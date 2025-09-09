@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Simple Gallery Test</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation Errors:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('Error'))
                        <div class="alert alert-danger">
                            <strong>Error!</strong> {{ session('Error') }}
                        </div>
                    @endif

                    @if (session('Sukses'))
                        <div class="alert alert-success">
                            <strong>Success!</strong> {{ session('Sukses') }}
                        </div>
                    @endif

                    {{-- Test 1: Minimal form without gallery items --}}
                    <h5>Test 1: Minimal Gallery (No Items)</h5>
                    <form action="{{ route('galeri.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Galeri</label>
                            <input type="text" name="nama_galeri" class="form-control" value="Test Gallery Minimal" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Test Submit Minimal</button>
                    </form>

                    <hr>

                    {{-- Test 2: Gallery with one image item --}}
                    <h5>Test 2: Gallery with Image Item</h5>
                    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Galeri</label>
                            <input type="text" name="nama_galeri" class="form-control" value="Test Gallery with Image" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <h6>Gallery Item</h6>
                        <div class="form-group mb-2">
                            <label>Type</label>
                            <select name="gallery_items[0][type]" class="form-control" required>
                                <option value="image">Image</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Sequence</label>
                            <input type="number" name="gallery_items[0][sequence]" class="form-control" value="1">
                        </div>
                        <div class="form-group mb-2">
                            <label>Image File</label>
                            <input type="file" name="gallery_items[0][file]" class="form-control" accept="image/*" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Test Submit with Image</button>
                    </form>

                    <hr>

                    {{-- Test 3: Gallery with youtube item --}}
                    <h5>Test 3: Gallery with YouTube Item</h5>
                    <form action="{{ route('galeri.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Galeri</label>
                            <input type="text" name="nama_galeri" class="form-control" value="Test Gallery with YouTube" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <h6>Gallery Item</h6>
                        <div class="form-group mb-2">
                            <label>Type</label>
                            <select name="gallery_items[0][type]" class="form-control" required>
                                <option value="youtube">YouTube</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Sequence</label>
                            <input type="number" name="gallery_items[0][sequence]" class="form-control" value="1">
                        </div>
                        <div class="form-group mb-2">
                            <label>YouTube URL</label>
                            <input type="url" name="gallery_items[0][youtube_url]" class="form-control" value="https://www.youtube.com/watch?v=dQw4w9WgXcQ" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">Test Submit with YouTube</button>
                    </form>

                    <hr>
                    <a href="{{ route('galeri.index') }}" class="btn btn-secondary">Back to Gallery List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
