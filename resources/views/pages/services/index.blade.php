@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Services</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('services.create') }}" class="btn btn-success d-flex justify-content-center">Add</a>
                </div>
            </div>
            <div class="section-body">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Invoice</th>
                                    <th>Received Date</th>
                                    <th>Costumer</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        Inv-001
                                    </td>
                                    <td>2017-01-09</td>
                                    <td>
                                        Ujang
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="badge badge-danger">unpaid</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center"><a href="/services-detail" class="btn btn-secondary box">Detail</a></div>
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
