@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Laptop</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('laptop.create') }}" class="btn btn-success d-flex justify-content-center">Add</a>
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
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Release Year</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                                @forelse ($datalaptop as $index => $laptop)
                                    <tr>
                                        <td>{{ $datalaptop->firstItem() + $index }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $laptop->photo) }}" alt="{{ $laptop->name }}"
                                                class="img-fill" width="100" height="100">
                                        </td>
                                        <td>{{ $laptop->brand }}</td>
                                        <td>{{ $laptop->model }}</td>
                                        <td>{{ $laptop->release_year }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('laptop.edit', $laptop->id) }}"
                                                    class="btn btn-warning box">Edit</a>

                                                <form action="{{ route('laptop.destroy', $laptop->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger box">Delete</button>
                                                </form>
                                            </div>
                                            <div class="form-group d-flex justify-content-center">
                                                <label class="custom-switch">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                        showToast(`Successfully changed laptop status to ${res.status.toUpperCase()}`, 'success');
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

        function showToast(message, type = 'info') {
            let bg = (type === 'success') ? '#28a745' : (type === 'error') ? '#dc3545' : '#007bff';
            let toast = $(`<div style="
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: ${bg};
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        z-index: 9999;
    ">${message}</div>`);
            $('body').append(toast);
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
        }
    </script>
@endsection
