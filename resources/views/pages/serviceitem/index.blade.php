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
                                @forelse ($dataserviceitem as $index => $serviceitem)
                                    <tr>
                                        <td>{{ $dataserviceitem->firstItem() + $index }}</td>
                                        <td>{{ $serviceitem->service_name }}</td>
                                        <td>{{ $serviceitem->formatted_price }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('serviceitem.edit', $serviceitem->id) }}"
                                                    class="btn btn-warning box">Edit</a>

                                                <form action="{{ route('serviceitem.destroy', $serviceitem->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger box">Delete</button>
                                                </form>
                                            </div>
                                            <div class="form-group d-flex justify-content-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" class="custom-switch-input toggle-status"
                                                        data-id="{{ $serviceitem->id }}"
                                                        {{ $serviceitem->status === 'active' ? 'checked' : '' }} />
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data Service item belum tersedia</td>
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

    {{-- toggle status service item --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '.toggle-status', function() {
            let checkbox = $(this);
            let serviceId = checkbox.data('id');
            let status = checkbox.is(':checked') ? 'active' : 'inactive';

            // Disable sementara biar gak spam klik
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

        // 🔔 Toast notification (pojok kanan bawah, tanpa emoji)
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
