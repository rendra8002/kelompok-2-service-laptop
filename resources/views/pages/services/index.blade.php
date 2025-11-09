@extends('layouts.app')
@section('content')
    <style>
        /* ✅ Scrollable table wrapper */
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
            position: relative;
            border: 1px solid #dee2e6;
        }

        /* ✅ Table spacing to make sticky header clean */
        .table-wrapper table {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        /* ✅ Sticky header fix */
        .table-wrapper thead th {
            position: sticky;
            top: 0;
            background-color: #ffffff !important;
            z-index: 30;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table-wrapper thead,
        .table-wrapper thead tr {
            background-color: #ffffff !important;
        }

        .table-wrapper thead th {
            border-bottom: 2px solid #dee2e6 !important;
        }

        /* ✅ Search box style */
        .search-box {
            width: 250px;
            margin-bottom: 10px;
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Service Data</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('services.create') }}" class="btn btn-success">Add</a>
                </div>
            </div>

            <div class="section-body">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Services</h4>
                            <input type="text" id="searchService" class="form-control search-box"
                                placeholder="Search service...">
                        </div>

                        <div class="table-wrapper table-responsive">
                            <table class="table table-bordered table-md text-center align-middle" id="serviceTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>No Invoice</th>
                                        <th>Customer</th>
                                        <th>Laptop</th>
                                        <th>Status</th>
                                        <th>Status Payment</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $index => $service)
                                        <tr>
                                            <td>{{ $index + $services->firstItem() }}</td>
                                            <td>{{ $service->no_invoice ?? 'INV-' . str_pad($service->id, 3, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td>{{ $service->customer->name ?? '-' }}</td>
                                            <td>{{ $service->laptop ? ucfirst($service->laptop->brand . ' ' . ($service->laptop->series ?? ($service->laptop->model ?? ''))) : '-' }}
                                            </td>
                                            <td>
                                                @switch($service->status)
                                                    @case('accepted')
                                                        <div class="badge badge-info">Accepted</div>
                                                    @break

                                                    @case('process')
                                                        <div class="badge badge-warning">Process</div>
                                                    @break

                                                    @case('finished')
                                                        <div class="badge badge-success">Finished</div>
                                                    @break

                                                    @case('taken')
                                                        <div class="badge badge-primary">Taken</div>
                                                    @break

                                                    @case('canceled')
                                                        <div class="badge badge-danger">Canceled</div>
                                                    @break

                                                    @default
                                                        <div class="badge badge-secondary">Unknown</div>
                                                @endswitch
                                            </td>
                                            <td>
                                                @php
                                                    $statusPaid =
                                                        $service->status_paid ??
                                                        (($service->paid ?? 0) >=
                                                        $service->details->sum('price') + ($service->other_cost ?? 0)
                                                            ? 'paid'
                                                            : 'unpaid');
                                                    $badgeClass = match ($statusPaid) {
                                                        'paid' => 'badge-success',
                                                        'debt' => 'badge-warning',
                                                        'unpaid' => 'badge-danger',
                                                        default => 'badge-secondary',
                                                    };
                                                @endphp
                                                <div class="badge {{ $badgeClass }}">{{ ucfirst($statusPaid) }}</div>
                                            </td>
                                            <td>
                                                <a href="{{ route('services.show', $service->id) }}"
                                                    class="btn btn-secondary btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No service records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- ✅ Pagination (selalu muncul walau 1 halaman) --}}
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    @if ($services->lastPage() > 1)
                                        {{ $services->onEachSide(1)->links('pagination::bootstrap-4') }}
                                    @else
                                        <ul class="pagination mb-0">
                                            <li class="page-item active">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                        </ul>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- ✅ JQuery Search --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('#searchService').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#serviceTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        </script>
    @endsection
