@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <form action="{{ route('serviceitem.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="section-header">
                    <h1>Manage Data User</h1>
                    <div class="section-header-breadcrumb d-flex justify-content-center"><a
                            href="{{ route('serviceitem.index') }}" class="btn btn-secondary ">Back</a></div>
                </div>
                <div class="section-body" style="display: flex; justify-content: center;">
                    <div class="card" style="width:800px;">
                        <div class="card-header">
                            <h4>Enter Service Item Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Service Name</label>
                                <input type="text" name="service_name" class="form-control" autofocus />
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Rp 0"
                                    oninput="formatRupiah(this)" />
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error') === 'duplicate_service')
            Swal.fire({
                title: 'Error!',
                text: 'Service name has already been used',
                icon: 'error',
                confirmButtonText: 'Fix',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.querySelector('input[name="service_name"]');
                    input.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    input.focus();
                }
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>



    <script>
        function formatRupiah(input) {
            // Ambil hanya angka
            let value = input.value.replace(/[^,\d]/g, '');
            let parts = value.split(',');
            let sisa = parts[0].length % 3;
            let rupiah = parts[0].substr(0, sisa);
            let ribuan = parts[0].substr(sisa).match(/\d{3}/gi);

            // Tambahkan titik setiap ribuan
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            // Tambahkan koma jika ada desimal
            rupiah = parts[1] !== undefined ? rupiah + ',' + parts[1] : rupiah;

            // Tambahkan prefix Rp
            input.value = rupiah ? 'Rp ' + rupiah : '';
        }
    </script>
@endsection
