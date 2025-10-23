@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <form action="{{ route('laptop.update', $datalaptop->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="section-header">
                    <h1>Manage Data Laptop</h1>
                    <div class="section-header-breadcrumb d-flex justify-content-center"><a href="{{ route('laptop.index') }}"
                            class="btn btn-secondary ">Back</a></div>
                </div>
                <div class="section-body" style="display: flex; justify-content: center;">
                    <div class="card" style="width:800px;">
                        <div class="card-header">
                            <h4>Enter New Laptop Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Photo</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photo"
                                        onchange="previewPhotoEdit(this)">
                                    <label class="custom-file-label" for="photo">
                                        {{ $datalaptop->photo ? basename($datalaptop->photo) : 'Choose file' }}
                                    </label>
                                </div>

                                <div class="mt-3">
                                    <p>Preview:</p>
                                    <div
                                        style="width:auto; height:300px; border:1px dashed #ccc; display:flex; align-items:center; justify-content:center;">
                                        <img id="photo-preview"
                                            src="{{ !empty($datalaptop->photo) ? asset('storage/' . $datalaptop->photo) : '' }}"
                                            alt="Preview"
                                            style="max-width:100%; max-height:100%; object-fit:contain; {{ empty($datalaptop->photo) ? 'display:none;' : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label>Brand</label><input type="text" name="brand"
                                    class="form-control" value="{{ old('brand', $datalaptop->brand) }}" /></div>
                            <div class="form-group"><label>Model</label><input type="text" name="model"
                                    class="form-control" value="{{ old('model', $datalaptop->model) }}" /></div>
                            <div class="form-group"><label>Release Year</label><input type="text" name="release_year"
                                    class="form-control" value="{{ old('release_year', $datalaptop->release_year) }}" />
                            </div>
                            <div class="card-footer text-left">
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <script>
        function previewPhotoEdit(input) {
            const file = input.files[0];
            const label = input.nextElementSibling;
            const preview = document.getElementById('photo-preview');

            if (file) {
                label.innerText = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                label.innerText = 'Choose file';
            }
        }
    </script>
@endsection
