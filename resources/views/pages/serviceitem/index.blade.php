@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Service Item</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('serviceitem.create') }}" class="btn btn-success d-flex justify-content-center">Add</a>
                </div>
            </div>
            <div class="section-body">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Service Name</th>
                                    <th>Price</th>
                                    <th style="width: 242px; text-align:center; ">Action</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        ganti lcd
                                    </td>
                                    <td>Rp.2.000.000,00</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="/serviceitem-edit" class="btn btn-warning box">Edit</a>

                                            <a href="#" class="btn btn-danger box">Delete</a>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="custom-switch-checkbox"
                                                    class="custom-switch-input" />
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
