@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="section-header">
                    <h1>Add Services</h1>
                    <div class="section-header-breadcrumb d-flex justify-content-center"><a
                            href="{{ route('services.index') }}" class="btn btn-secondary ">Back</a></div>
                </div>
                <div class="section-body" style="display: flex; justify-content: center;">
                    <div class="card col-lg-12">
                        <div class="card-header">
                            <h4>Enter Services Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>No. Invoice</label>
                                    <input type="text" name="no_invoice" class="form-control" value="{{ $no_invoice }}"
                                        readonly>
                                </div>


                                <div class="form-group col-md-6">
                                    <label>Customer</label>
                                    <select name="customer_id" class="form-control">
                                        <option hidden selected>Choose Customer</option>
                                        @forelse ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @empty
                                            <option disabled>No active customers available</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Technician</label>
                                    <select name="technician_id" class="form-control">
                                        <option hidden selected>Choose Technician</option>
                                        @forelse ($technicians as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                        @empty
                                            <option disabled>No active technicians available</option>
                                        @endforelse
                                    </select>
                                </div>

                                @php use Illuminate\Support\Str; @endphp

                                <div class="form-group col-md-6">
                                    <label for="laptop_id">Laptop</label>
                                    <select name="laptop_id" id="laptop_id" class="form-control selectpicker"
                                        data-live-search="true" required>
                                        <option hidden selected>Choose Laptop</option>
                                        @forelse ($laptops as $laptop)
                                            <option value="{{ $laptop->id }}">
                                                {{ Str::title($laptop->brand . ' ' . ($laptop->series ?? ($laptop->model ?? ''))) }}
                                            </option>
                                        @empty
                                            <option disabled>No laptops found</option>
                                        @endforelse
                                    </select>
                                </div>


                                <div class="form-group col-md-6">
                                    <label>Damage Description</label>
                                    <input type="text" name="damage_description" class="form-control" />
                                </div>

                            </div>

                            {{-- saya mau data dari table ini ke table servicedetails --}}
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                <th style="width: 36px; ">Action</th>
                                                <th>Service Name</th>
                                                <th>Price</th>
                                            </tr>
                                            <tbody id="table-body-servicetype">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer text-right">
                                        <div>
                                            <button type="button" id="add-row-servicetype"
                                                class="btn btn-secondary w-100">Add
                                                Other Service</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-left">
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@push('costom.js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Aktifkan fitur pencarian Bootstrap Select
            $('.selectpicker').selectpicker({
                liveSearch: true,
                style: 'btn-light',
                size: 5
            });
        });
    </script>


    <script>
        // === Format otomatis input Other Cost ke Rupiah ===
        const otherCostInput = document.getElementById('other_cost');

        if (otherCostInput) {
            otherCostInput.addEventListener('input', function(e) {
                // Hapus semua karakter selain angka
                let value = e.target.value.replace(/[^,\d]/g, '');
                if (value) {
                    e.target.value = formatRupiah(value);
                } else {
                    e.target.value = '';
                }
            });
        }

        // === Bersihkan format Rupiah sebelum form dikirim ===
        document.querySelector('form').addEventListener('submit', function() {
            const otherCostInput = document.getElementById('other_cost');
            if (otherCostInput) {
                // Ambil angka murni dari input
                let cleanValue = otherCostInput.value.replace(/[^0-9]/g, '');
                otherCostInput.value = cleanValue;
            }
        });

        // === Fungsi format Rupiah ===
        function formatRupiah(angka) {
            angka = angka.toString().replace(/[^,\d]/g, '');
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah ? 'Rp ' + rupiah : '';
        }
    </script>


    <script>
        const serviceTypes = @json($serviceTypes);
    </script>


    <script>
        // Lempar data service item dari Laravel ke JavaScript
        const serviceTypes = @json($serviceTypes);
    </script>

    <script>
        $(document).ready(function() {
            addNewServiceTypeRow();
            $('#add-row-servicetype').on('click', function() {
                addNewServiceTypeRow();
            });
        })

        function addNewServiceTypeRow() {
            let rowCount = $('#table-body-servicetype tr').length;
            let row = rowCount + 1;

            // Buat <option> pakai data dari Laravel
            let optionsHtml = '<option hidden>Choose Service Item</option>';
            serviceTypes.forEach(type => {
                optionsHtml +=
                    `<option value="${type.id}" data-price="${type.price}">${type.service_name}</option>`;
            });

            let rowHtml = `
        <tr class="servicetype-row">
            <td>${row}</td>
            <td>
                <button onclick="removeServiceTypeRow(this)" class="btn btn-icon btn-danger btn-remove-product-purcahse-row">
                    <i class="fas fa-times"></i>
                </button>
            </td>
            <td>
                <select class="form-control select2 service-select" name="service_type[]" id="service_type_${row}">
                    ${optionsHtml}
                </select>
            </td>
           <td>
                <input type="text" disabled readonly id="price_display_${row}" class="form-control" placeholder="0">
                <input type="hidden" name="price[]" id="price_${row}">
            </td>

        </tr>
    `;

            $('#table-body-servicetype').append(rowHtml);
            updateNumberServiceTypeRow();
        }

        // Update harga otomatis
        $(document).on('change', '.service-select', function() {
            let selectedOption = $(this).find(':selected');
            let price = selectedOption.data('price') || 0;
            let row = $(this).closest('tr');
            row.find('#price_display_' + (row.index() + 1)).val(formatRupiah(price));
            row.find('#price_' + (row.index() + 1)).val(price); // isi hidden input
        });


        // Fungsi format Rupiah sederhana
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }




        // number data generator
        function updateNumberServiceTypeRow() {
            let rowCount = $('#table-body-servicetype tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
            toggleServiceTypeRowButtons();
        }

        // check row === 1 if 1  disable remove button  
        function toggleServiceTypeRowButtons() {
            let rowCount = $('#table-body-servicetype tr').length;
            $('.btn-remove-product-purcahse-row').prop('disabled', rowCount < 2);
        }

        // fungsi buat delete
        function removeServiceTypeRow(row) {
            $(row).closest('.servicetype-row').remove();

            updateNumberServiceTypeRow();
        }
    </script>
@endpush
