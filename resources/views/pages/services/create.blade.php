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
                                <input type="text" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Costumer</label>
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label>Technician</label>
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Laptop</label>
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Damage Description</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Other Cost</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>Payment Method</label>
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
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
                        </div>


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
@push('costom.js')
    <script>
        $(document).ready(function() {
            addNewServiceTypeRow();
            $('#add-row-servicetype').on('click', function() {
                addNewServiceTypeRow();
            });
        })

        function addNewServiceTypeRow() {
            let rowCount = $('#table-body-servicetype tr').length;
            row = rowCount + 1;


            let rowHtml = `
                <tr class="servicetype-row">
                    <td>${row}</td>
                    <td>
                        <button onclick="removeServiceTypeRow(this)" class="btn btn-icon btn-danger btn-remove-product-purcahse-row"><i class="fas fa-times"></i></button>
                    </td>
                    <td>
                        <select class="form-control select2" name="service_type[]" id="service_type_${row}">
                            <option hidden>Choose Service Item</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="2">Option 3</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="price" disabled readonly id="price_${row}" class="form-control" placeholder="0">
                    </td>
                </tr>
            `;

            $('#table-body-servicetype').append(rowHtml);
            updateNumberServiceTypeRow();
        }



        // number data generator
        function updateNumberServiceTypeRow() {
            let rowCount = $('#table-body-servicetype tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
            toggleServiceTypeRowButtons();
        }

        // check row === 1 if 1  disable remove button  
        function toggleServiceTypeRowButtons() {
            let rowCount = $('#table-body-servicetype tr').length;
            $('.btn-remove-product-purcahse-row').prop('disabled', rowCount < 2);
        }

        // fungsi buat delete
        function removeServiceTypeRow(row) {
            $(row).closest('.servicetype-row').remove();

            updateNumberServiceTypeRow();
        }
    </script>
@endpush
