@extends('layouts.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                {{-- Total Customer --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Customers</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalCustomers }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Technician --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Technicians</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalTechnicians }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Service In Progress --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Services In Progress</h4>
                            </div>
                            <div class="card-body">
                                {{ $servicesInProgress }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Finished Services --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Finished Services</h4>
                            </div>
                            <div class="card-body">
                                {{ $finishedServices }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            {{-- 🔹 Tabel data service --}}
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Services</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No. Invoice</th>
                                            <th>Customer</th>
                                            <th>Laptop</th>
                                            <th>Status</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($services as $index => $service)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $service->no_invoice ?? '-' }}</td>
                                                <td>{{ $service->customer->name ?? 'N/A' }}</td>
                                                <td>
                                                    {{-- tampilkan nama laptop jika ada relasi --}}
                                                    {{ $service->laptop->brand ?? 'Laptop ID: ' . $service->laptop_id }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge 
                                                        @if ($service->status == 'finished') badge-success
                                                        @elseif($service->status == 'process') badge-warning
                                                        @elseif($service->status == 'accepted') badge-info
                                                        @elseif($service->status == 'taken') badge-primary
                                                        @else badge-danger @endif">
                                                        {{ ucfirst($service->status) }}
                                                    </span>
                                                </td>
                                                <td>Rp {{ number_format($service->total_cost, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No service data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
