@extends('layouts.app')
@section('content')
    <style>
        /* ✅ Floating toast alert */
        .floating-alert {
            display: none;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 8px;
            color: #fff;
            font-weight: 500;
            text-align: center;
        }

        .floating-alert.success {
            background: #47c363;
        }

        .floating-alert.error {
            background: #fc544b;
        }

        /* ✅ Search input styling */
        .search-box {
            width: 250px;
            margin-bottom: 15px;
        }

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
            /* penting! biar th tidak nyatu border */
            border-spacing: 0;
        }

        /* ✅ Sticky header fix agar data tidak nembus */
        .table-wrapper thead th {
            position: sticky;
            top: 0;
            background-color: #ffffff !important;
            /* paksa solid background */
            z-index: 30;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* ✅ Tambahan biar header full solid */
        .table-wrapper thead,
        .table-wrapper thead tr {
            background-color: #ffffff !important;
        }

        /* ✅ Tambahkan garis pemisah jelas */
        .table-wrapper thead th {
            border-bottom: 2px solid #dee2e6 !important;
        }

        /* ✅ Pastikan tbody selalu di bawah thead */
        .table-wrapper tbody {
            position: relative;
            z-index: 1;
            background-color: #fff;
            /* biar clean */
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Laptop</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('laptop.create') }}" class="btn btn-success d-flex justify-content-center">Add</a>
                </div>
            </div>

            {{-- ✅ Session toast notification --}}
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
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Laptop</h4>
                            {{-- ✅ Search box --}}
                            <input type="text" id="searchLaptop" class="form-control search-box"
                                placeholder="Search laptop...">
                        </div>

                        {{-- ✅ Scrollable table --}}
                        <div class="table-wrapper table-responsive">
                            <table class="table table-bordered table-md" id="laptopTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Release Year</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datalaptop as $index => $laptop)
                                        <tr>
                                            <td>{{ $datalaptop->firstItem() + $index }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $laptop->photo) }}"
                                                    alt="{{ $laptop->brand }}" class="img-fill" width="50"
                                                    height="50">
                                            </td>
                                            <td>{{ $laptop->brand }}</td>
                                            <td>{{ $laptop->model }}</td>
                                            <td>{{ $laptop->release_year }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('laptop.edit', $laptop->id) }}"
                                                        class="btn btn-warning box">Edit</a>

                                                    <form action="{{ route('laptop.destroy', $laptop->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger box btn-delete">Delete</button>
                                                    </form>

                                                    <label class="custom-switch ml-2">
                                                        <input type="checkbox" class="custom-switch-input toggle-status"
                                                            data-id="{{ $laptop->id }}"
                                                            {{ $laptop->status === 'active' ? 'checked' : '' }}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Data Laptop belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- ✅ Pagination --}}
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                @if ($datalaptop->lastPage() > 1)
                                    {{ $datalaptop->onEachSide(1)->links('pagination::bootstrap-4') }}
                                @else
                                    {{-- ✅ Tampilkan tombol pagination dummy walau cuma 1 halaman --}}
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

    <script>
        // ✅ SweetAlert2 Delete Confirmation (English)
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This item will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        // ✅ Search filter (client-side)
        $('#searchLaptop').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#laptopTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // ✅ Toggle status via AJAX
        $(document).on('change', '.toggle-status', function() {
            let checkbox = $(this);
            let laptopId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 'active' : 'inactive';

            checkbox.prop('disabled', true);

            $.ajax({
                url: "{{ route('laptop.toggle-status', ['id' => ':id']) }}".replace(':id', laptopId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(res) {
                    if (res.success) {
                        showToast(`Successfully changed laptop status to ${res.status.toUpperCase()}`,
                            'success');
                    } else {
                        showToast('Failed to update laptop status', 'error');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                },
                error: function() {
                    showToast('Error updating laptop status', 'error');
                    checkbox.prop('checked', !checkbox.is(':checked'));
                },
                complete: function() {
                    checkbox.prop('disabled', false);
                }
            });
        });

        // ✅ Mini toast bawah kanan (sama kayak di index user)
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
