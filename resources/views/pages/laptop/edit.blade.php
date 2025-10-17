@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Laptop</h1>
                <div class="section-header-breadcrumb d-flex justify-content-center"><a href="{{ route('user.index') }}"
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
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Release Year</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="card-footer text-left">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
