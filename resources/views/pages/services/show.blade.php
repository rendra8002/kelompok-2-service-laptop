@extends('layouts.app')
@section('content')
      <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Services</h1>
                <div class="section-header-breadcrumb d-flex justify-content-center"><a href="{{ route('services.index') }}"
                        class="btn btn-secondary ">Back</a></div>
            </div>
            <div class="section-body" style="display: flex; justify-content: center;">
                <div class="card col-lg-12">
                    <form action="" method="POST" enctype="multipart/form-data"></form>
                    <div class="card-header">
                        <h4>Enter Services Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Invoice</label>
                                <p>Invoice number</p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Costumer</label>
                               <p>Costumer</p>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label>Technician</label>
                              <p>Technician</p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Laptop</label>
                                <p>Laptop </p>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Damage Description</label>
                                <p>description</p>
                            </div>
                            <div class="form-group col-md-6">
                                <p>Other cost</p>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Payment Method</label>
                               <p>Method</p>
                            </div>
                        </div>

                        {{-- <div class="col-lg-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th style="width: 36px; ">Action</th>
                                            <th>Service Name</th>
                                            <th>Estimated Cost</th>
                                        </tr>
                                        <tbody id="table-body-servicetype">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-right">
                                    <div>
                                        <button type="button" id="add-row-servicetype" class="btn btn-secondary w-100">Add
                                            Other Service</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        {{-- <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Service Detail Form</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table table-hover table-lg">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td style="width: 5px">Action</td>
                                                    <td>Service Type</td>
                                                    <td>Price</td>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body-servicetype">

                                            </tbody>
                                        </table>
                                        <div>
                                            <button type="button" id="add-row-servicetype"
                                                class="btn btn-secondary w-100">Add Other Service</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="card-footer text-left">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
