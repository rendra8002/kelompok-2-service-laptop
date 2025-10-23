@extends('layouts.app')
@section('content')
    {{-- style untul badge role --}}
    <style>
        .user.admin {
            color: #fff;
            text-decoration: none;
            background-color: #3abaf4;
        }

        .user.costumer {
            color: #fff;
            text-decoration: none;
            background-color: #63ed7a;
        }

        .user.technician {
            color: #ffffff;
            text-decoration: none;
            background-color: #ffc107;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data User</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('user.create') }}" class="btn btn-success d-flex justify-content-center">Add</a>
                </div>
            </div>
            <div class="section-body">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Detail</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                                @forelse ($datauser as $index => $user)
                                    <tr>
                                        <td>{{ $datauser->firstItem() + $index }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                                class="img-fill" width="100" height="100">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="badge user {{ strtolower($user->role) }}">{{ $user->role }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center"><a
                                                    href="{{ route('user.show', $user->id) }}"
                                                    class="btn btn-secondary box">Detail</a></div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-warning box">Edit</a>

                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger box">Delete</button>
                                                </form>
                                            </div>
                                            <div class="form-group d-flex justify-content-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                        class="custom-switch-input toggle-status"
                                                        data-id="{{ $user->id }}"{{ $user->status === 'active' ? 'checked' : '' }} />
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data User belum tersedia</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        {{-- <div class="card-footer text-right">
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
                        </div> --}}

                        {{-- <div class="card-footer text-right">
                            {{ $datauser->links('pagination::bootstrap-4') }}
                        </div> --}}

                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    {{-- Tombol "Sebelumnya" --}}
                                    <li class="page-item {{ $datauser->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $datauser->previousPageUrl() ?? '#' }}"
                                            tabindex="-1">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    {{-- Nomor halaman --}}
                                    @for ($i = 1; $i <= $datauser->lastPage(); $i++)
                                        <li class="page-item {{ $i == $datauser->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $datauser->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Tombol "Selanjutnya" --}}
                                    <li class="page-item {{ !$datauser->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $datauser->nextPageUrl() ?? '#' }}">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- buat toggle --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '.toggle-status', function() {
            let checkbox = $(this);
            let userId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 'active' : 'inactive';

            // disable sementara biar gak spam klik
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
                        showToast(`Successfully changed user status to ${res.status}`, 'success');
                    } else {
                        showToast('Failed to update user status', 'error');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                },
                error: function() {
                    showToast('Error updating user status.', 'error');
                    checkbox.prop('checked', !checkbox.is(':checked'));
                },
                complete: function() {
                    checkbox.prop('disabled', false);
                }
            });
        });

        // 🔔 Fungsi notifikasi pojok kanan bawah (tanpa emoji)
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
