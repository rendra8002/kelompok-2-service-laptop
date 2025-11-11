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
    </style>


    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data User</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('user.create') }}" class="btn btn-success">Add</a>
                </div>
            </div>
            {{-- ✅ Session toast (same position as status toast) --}}
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
                                <h4>Data User</h4>
                                {{-- ✅ Search box --}}
                                <input type="text" id="searchUser" class="form-control search-box"
                                    placeholder="Search user...">
                            </div>

                            <div class="table-wrapper table-responsive">
                                <table class="table table-bordered table-md" id="userTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th style="width: 100px">Status</th>
                                            <th style="width: 242px; text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datauser as $index => $user)
                                            <tr>
                                                <td>{{ $datauser->firstItem() + $index }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                                        alt="{{ $user->name }}" class="img-fill" width="50"
                                                        height="50">
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="badge user {{ strtolower($user->role) }}">
                                                            {{ ucfirst($user->role) }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group d-flex justify-content-center">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="custom-switch-checkbox"
                                                                class="custom-switch-input toggle-status"
                                                                data-id="{{ $user->id }}"{{ $user->status === 'active' ? 'checked' : '' }} />
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="btn btn-warning box">Edit</a>
                                                        <a href="{{ route('user.show', $user->id) }}"
                                                            class="btn btn-secondary box">Detail</a>
                                                        <form action="{{ route('user.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger box btn-delete">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data User belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- Pagination --}}
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    @if ($datauser->lastPage() > 1)
                                        {{ $datauser->onEachSide(1)->links('pagination::bootstrap-4') }}
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
            </div>
        </section>
    </div>



    {{-- delet konfirm --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ✅ Delete confirmation using SweetAlert2
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault(); // prevent immediate form submit
            const form = $(this).closest('form');   

            Swal.fire({
                title: 'Are you sure?',
                text: "Deleted data cannot be recovered!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // proceed with delete if confirmed
                }
            });
        });
    </script>

    {{-- end delet --}}


    <script>
        $(document).ready(function() {
            const successToast = $('#toastSuccess');
            const errorToast = $('#toastError');

            if (successToast.length) {
                successToast.slideDown(300).delay(2500).slideUp(400);
            }
            if (errorToast.length) {
                errorToast.slideDown(300).delay(2500).slideUp(400);
            }
        });


        // ✅ Search filter (client-side)
        $('#searchUser').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#userTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // ✅ Toggle status via AJAX
        $(document).on('change', '.toggle-status', function() {
            let checkbox = $(this);
            let userId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 'active' : 'inactive';
            checkbox.prop('disabled', true);

            $.ajax({
                url: "{{ route('user.toggle-status', ['id' => ':id']) }}".replace(':id', userId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(res) {
                    if (res.success) {
                        showToast(`Status changed to ${res.status}`, 'success');
                    } else {
                        showToast('Failed to update status', 'error');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                },
                error: function() {
                    showToast('Error updating status.', 'error');
                    checkbox.prop('checked', !checkbox.is(':checked'));
                },
                complete: function() {
                    checkbox.prop('disabled', false);
                }
            });
        });

        // ✅ Mini toast bawah kanan
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
