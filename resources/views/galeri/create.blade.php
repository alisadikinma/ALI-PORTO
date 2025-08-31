@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        {{-- Nama Galeri --}}
                        <div class="form-group mb-2">
                            <label for="">Nama Galeri <abbr title="" style="color: black">*</abbr></label>
                            <input type="text" class="form-control"
                                   placeholder="Masukkan Judul Gambar disini...."
                                   name="nama_galeri" value="{{ old('nama_galeri') }}">
                        </div>

                        {{-- Jenis Galeri --}}
                        <div class="form-group mb-2">
                            <label for="">Jenis Galeri</label>
                            <select name="jenis_galeri" id="dropdown" class="form-control">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Banner" {{ old('jenis_galeri') == 'Banner' ? 'selected' : '' }}>Banner</option>
                                <option value="Galeri" {{ old('jenis_galeri') == 'Galeri' ? 'selected' : '' }}>Galeri</option>
                            </select>
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group mb-2">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan_galeri" id="editor" cols="30" rows="10">{{ old('keterangan_galeri') }}</textarea>
                        </div>

                        {{-- Gambar Utama --}}
                        <div class="form-group mb-2">
                            <label for="">Gambar Utama <abbr title="" style="color: black">*</abbr> </label>
                            <input id="inputImg" type="file" accept="image/*" name="gambar_galeri" class="form-control">
                            <img class="d-none w-25 h-25 my-2" id="previewImg" src="#" alt="Preview image">
                        </div>

                        {{-- Gambar Galeri 1 --}}
                        <div class="form-group mb-2">
                            <label for="">Gambar Galeri 1</label>
                            <input id="inputImg1" type="file" accept="image/*" name="gambar_galeri1" class="form-control">
                            <img class="d-none w-25 h-25 my-2" id="previewImg1" src="#" alt="Preview image">
                        </div>

                        {{-- Gambar Galeri 2 --}}
                        <div class="form-group mb-2">
                            <label for="">Gambar Galeri 2</label>
                            <input id="inputImg2" type="file" accept="image/*" name="gambar_galeri2" class="form-control">
                            <img class="d-none w-25 h-25 my-2" id="previewImg2" src="#" alt="Preview image">
                        </div>

                        {{-- Gambar Galeri 3 --}}
                        <div class="form-group mb-2">
                            <label for="">Gambar Galeri 3</label>
                            <input id="inputImg3" type="file" accept="image/*" name="gambar_galeri3" class="form-control">
                            <img class="d-none w-25 h-25 my-2" id="previewImg3" src="#" alt="Preview image">
                        </div>

                        {{-- Video Galeri --}}
                        <div class="form-group mb-2">
                            <label for="">Video Galeri</label>
                            <input type="file" accept="video/*" name="video_galeri" class="form-control">
                        </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

        // Preview untuk setiap gambar
        function previewImage(inputId, previewId) {
            document.getElementById(inputId).addEventListener('change', function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewId).setAttribute('src', e.target.result);
                        document.getElementById(previewId).classList.remove("d-none");
                        document.getElementById(previewId).classList.add("d-block");
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        }

        previewImage('inputImg', 'previewImg');
        previewImage('inputImg1', 'previewImg1');
        previewImage('inputImg2', 'previewImg2');
        previewImage('inputImg3', 'previewImg3');
    </script>
@endsection
