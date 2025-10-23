@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <form action="{{ route('user.update', $datauser->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="section-header">
                    <h1>Manage Data User</h1>
                    <div class="section-header-breadcrumb d-flex justify-content-center"><a href="{{ route('user.index') }}"
                            class="btn btn-secondary ">Back</a></div>
                </div>
                <div class="section-body" style="display: flex; justify-content: center;">
                    <div class="card" style="width:800px;">
                        <div class="card-header">
                            <h4>Enter New User Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Photo</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photo"
                                        onchange="previewPhotoEdit(this)">
                                    <label class="custom-file-label" for="photo">
                                        {{ $datauser->photo ? basename($datauser->photo) : 'Choose file' }}
                                    </label>
                                </div>

                                <div class="mt-3">
                                    <p>Preview:</p>
                                    <div
                                        style="width:auto; height:300px; border:1px dashed #ccc; display:flex; align-items:center; justify-content:center;">
                                        <img id="photo-preview"
                                            src="{{ !empty($datauser->photo) ? asset('storage/' . $datauser->photo) : '' }}"
                                            alt="Preview"
                                            style="max-width:100%; max-height:100%; object-fit:contain; {{ empty($datauser->photo) ? 'display:none;' : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $datauser->name) }}">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $datauser->address) }}" />
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', $datauser->phone_number) }}" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control"
                                    value="••••••••" />
                                <small class="">Fill in only if you want to change your current password</small>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="admin" {{ old('role', $datauser->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="technician"
                                        {{ old('role', $datauser->role) == 'technician' ? 'selected' : '' }}>Technician
                                    </option>
                                    <option value="costumer"
                                        {{ old('role', $datauser->role) == 'costumer' ? 'selected' : '' }}>Costumer
                                    </option>
                                </select>
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
