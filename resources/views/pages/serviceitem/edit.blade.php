@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <form action="{{ route('serviceitem.update', $serviceitem->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="section-header">
                    <h1>Manage Data User</h1>
                    <div class="section-header-breadcrumb d-flex justify-content-center"><a
                            href="{{ route('serviceitem.index') }}" class="btn btn-secondary ">Back</a></div>
                </div>
                <div class="section-body" style="display: flex; justify-content: center;">
                    <div class="card" style="width:800px;">
                        <div class="card-header">
                            <h4>Enter New User Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Service Name</label>
                                <input type="text" class="form-control"
                                    value="{{ old('service_name', $serviceitem->service_name) }}" />
                            </div>
                            {{-- <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" />
                        </div> --}}
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Rp 0"
                                    value="{{ 'Rp ' . number_format($serviceitem->price, 0, ',', '.') }}"
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
    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^,\d]/g, '');
            let parts = value.split(',');
            let sisa = parts[0].length % 3;
            let rupiah = parts[0].substr(0, sisa);
            let ribuan = parts[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = parts[1] !== undefined ? rupiah + ',' + parts[1] : rupiah;
            input.value = rupiah ? 'Rp ' + rupiah : '';
        }
    </script>
@endsection
