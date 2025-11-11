@extends('layouts.app')
@section('content')
    <style>
        /* ✅ Wrapper scroll */
        .table-wrapper {
            max-height: 800px;
            overflow-y: auto;
            position: relative;
            border: 1px solid #dee2e6;
        }

        /* ✅ Pastikan table tidak menimpa header */
        .table-wrapper table {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        /* ✅ Sticky header fix agar data tidak nembus */
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

        .table-wrapper tbody {
            position: relative;
            z-index: 1;
            background-color: #fff;
        }

        .search-box {
            width: 250px;
            margin-bottom: 15px;
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Service Item</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('serviceitem.create') }}" class="btn btn-success">Add</a>
                </div>
            </div>

            {{-- ✅ SweetAlert Success/Error --}}
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast("{{ session('success') }}", 'success');
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showToast("{{ session('error') }}", 'error');
                    });
                </script>
            @endif

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Data Service Item</h4>
                                {{-- ✅ Search box --}}
                                <input type="text" id="searchService" class="form-control search-box"
                                    placeholder="Search service item...">
                            </div>

                            <div class="table-wrapper table-responsive">
                                <table class="table table-bordered table-md" id="serviceTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>Service Name</th>
                                            <th>Price</th>
                                            <th style="width: 242px; text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataserviceitem as $index => $serviceitem)
                                            <tr>
                                                <td>{{ $dataserviceitem->firstItem() + $index }}</td>
                                                <td>{{ $serviceitem->service_name }}</td>
                                                <td>Rp {{ number_format($serviceitem->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('serviceitem.edit', $serviceitem->id) }}"
                                                            class="btn btn-warning box mr-2">Edit</a>

                                                        <form action="{{ route('serviceitem.destroy', $serviceitem->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger box"
                                                                onclick="return confirm('Are you sure want to delete this item?')">
                                                                Delete
                                                            </button>
                                                        </form>

                                                        <label class="custom-switch ml-3">
                                                            <input type="checkbox" class="custom-switch-input toggle-status"
                                                                data-id="{{ $serviceitem->id }}"
                                                                {{ $serviceitem->status === 'active' ? 'checked' : '' }}>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data Service Item belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- ✅ Pagination --}}
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    @if ($dataserviceitem->lastPage() > 1)
                                        {{ $dataserviceitem->onEachSide(1)->links('pagination::bootstrap-4') }}
                                    @else
                                        {{-- ✅ Tampilkan pagination dummy walau cuma 1 halaman --}}
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
            </div>
        </section>
    </div>

    {{-- ✅ JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ✅ Client-side search filter
        $('#searchService').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#serviceTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // ✅ Toggle status AJAX
        $(document).on('change', '.toggle-status', function() {
            let checkbox = $(this);
            let serviceId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 'active' : 'inactive';
            checkbox.prop('disabled', true);

            $.ajax({
                url: "{{ route('serviceitem.toggle-status', ['id' => ':id']) }}".replace(':id', serviceId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(res) {
                    if (res.success) {
                        showToast(`Successfully changed service item status to ${res.status}`,
                            'success');
                    } else {
                        showToast('Failed to update service item status.', 'error');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                },
                error: function() {
                    showToast('Error updating service item status.', 'error');
                    checkbox.prop('checked', !checkbox.is(':checked'));
                },
                complete: function() {
                    checkbox.prop('disabled', false);
                }
            });
        });

        // ✅ Floating toast bawah kanan
        function showToast(message, type = 'info') {
            let bg = (type === 'success') ? '#47c363' :
                (type === 'error') ? '#fc544b' :
                (type === 'warning') ? '#ffa426' : '#3abaf4';

            let toast = $(`
                <div style="
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    background: ${bg};
                    color: #fff;
                    padding: 12px 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                    z-index: 9999;
                    font-size: 14px;
                    opacity: 0;
                    transform: translateY(20px);
                    transition: all 0.3s ease;
                ">
                    ${message}
                </div>
            `);

            $('body').append(toast);
            setTimeout(() => toast.css({
                opacity: 1,
                transform: 'translateY(0)'
            }), 50);
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2500);
        }
    </script>
@endsection
