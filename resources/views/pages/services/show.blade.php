@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Service Detail</h1>
                <div class="section-header-breadcrumb">
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>

            <div class="section-body">
                {{-- 🔹 Informasi Utama --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Service Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>No. Invoice</label>
                                <input type="text" class="form-control" value="{{ $service->no_invoice ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Received Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $service->received_date ? \Carbon\Carbon::parse($service->received_date)->format('d M Y, H:i') : '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Completed Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $service->completed_date ? \Carbon\Carbon::parse($service->completed_date)->format('d M Y, H:i') : '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Customer</label>
                                <input type="text" class="form-control" value="{{ $service->customer->name ?? '-' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Technician</label>
                                <input type="text" class="form-control" value="{{ $service->technician->name ?? '-' }}"
                                    readonly>
                            </div>
                            @php use Illuminate\Support\Str; @endphp
                            <div class="form-group col-md-6">
                                <label>Laptop</label>
                                <input type="text" class="form-control"
                                    value="{{ $service->laptop ? Str::title(trim($service->laptop->brand . ' ' . ($service->laptop->series ?? ($service->laptop->model ?? '')))) : '-' }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach (['accepted', 'process', 'finished', 'taken', 'canceled'] as $statusOption)
                                        <option value="{{ $statusOption }}"
                                            {{ $service->status === $statusOption ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="statusSave" class="text-success" style="display:none;">Status updated!</small>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Damage Description</label>
                                <textarea class="form-control" rows="3" readonly>{{ $service->damage_description }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Other Cost</label>
                                <input type="text" id="otherCost" class="form-control"
                                    value="{{ $service->other_cost && $service->other_cost > 0 ? 'Rp ' . number_format($service->other_cost, 0, ',', '.') : 'Rp 0' }}"
                                    placeholder="Masukkan biaya tambahan">
                                <small class="text-success" id="saveStatus" style="display:none;">Saved!</small>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 🔹 Detail Service Items --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Service Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Service Name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceDetails">
                                    @forelse ($service->details as $i => $detail)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><input type="text" class="form-control"
                                                    value="{{ $detail->serviceitem->service_name ?? '-' }}" readonly></td>
                                            <td><input type="text" class="form-control text-right price-item"
                                                    value="Rp {{ number_format($detail->price, 0, ',', '.') }}" readonly>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No service details available.
                                            </td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="2" class="text-right font-weight-bold">Estimated Cost</td>
                                        <td><input type="text" id="tableTotal"
                                                class="form-control text-right font-weight-bold" readonly></td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- 🔹 Total Keseluruhan --}}
                            <div class="form-group mb-3">
                                <label>Total Cost (Include Other Cost)</label>
                                <input type="text" id="total_cost" class="form-control font-weight-bold" readonly>
                            </div>

                            {{-- 🔹 Pembayaran --}}
                            <div class="form-group mb-3">
                                <label>Payment Method</label>
                                <select name="paymentmethod" id="paymentmethod" class="form-control">
                                    <option value="">-- Select Payment Method --</option>
                                    <option value="cash" {{ $service->paymentmethod == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="transfer" {{ $service->paymentmethod == 'transfer' ? 'selected' : '' }}>
                                        Transfer</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Paid</label>
                                <input type="text" id="paid" class="form-control" value="Rp 0">
                            </div>

                            <div class="form-group mb-3">
                                <label>Remaining Paid</label>
                                <input type="text" id="remaining_paid" class="form-control" readonly
                                    value="Rp {{ ($service->details->sum('price') ?? 0) + ($service->other_cost ?? 0) - ($service->paid ?? 0) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label>Change</label>
                                <input type="text" id="change" class="form-control" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label>Status Paid</label>
                                <div id="status_paid_container">
                                    @php
                                        $badgeClass = match ($service->status_paid) {
                                            'paid' => 'badge-success',
                                            'debt' => 'badge-warning',
                                            'unpaid' => 'badge-danger',
                                            default => 'badge-secondary',
                                        };
                                    @endphp
                                    <span id="status_paid_badge"
                                        class="badge {{ $badgeClass }} px-3 py-2 text-uppercase">
                                        {{ $service->status_paid ?? 'UNKNOWN' }}
                                    </span>
                                </div>
                            </div>

                            {{-- 🔹 Tombol Submit Payment --}}
                            <button id="submitPayment" class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i> Submit Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        const statusSelect = document.getElementById('status');
        const statusSave = document.getElementById('statusSave');

        // 🔹 Update status servis
        statusSelect.addEventListener('change', () => {
            const newStatus = statusSelect.value;
            fetch("{{ route('services.updateStatus', $service->id) }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        statusSave.style.display = 'inline';
                        setTimeout(() => statusSave.style.display = 'none', 1500);
                    } else {
                        Swal.fire('Error', 'Gagal memperbarui status', 'error');
                    }
                })
                .catch(() => Swal.fire('Error', 'Terjadi kesalahan server', 'error'));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const otherCostInput = document.getElementById('otherCost');
            const totalCostInput = document.getElementById('total_cost');
            const tableTotal = document.getElementById('tableTotal');
            const priceItems = document.querySelectorAll('.price-item');
            const saveStatus = document.getElementById('saveStatus');
            const paidInput = document.getElementById('paid');
            const remainingInput = document.getElementById('remaining_paid');
            const changeInput = document.getElementById('change');
            const statusPaidBadge = document.getElementById('status_paid_badge');
            const submitBtn = document.getElementById('submitPayment');
            const paymentMethod = document.getElementById('paymentmethod');

            let initialPaid = parseInt("{{ $service->paid ?? 0 }}");
            let totalFromDB = parseInt(
                "{{ ($service->details->sum('price') ?? 0) + ($service->other_cost ?? 0) }}"
            );

            // 🔹 Format Rupiah
            const formatRupiah = (angka) => {
                angka = angka.toString().replace(/[^,\d]/g, '');
                if (!angka) return 'Rp 0';
                const split = angka.split(',');
                const sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                const ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
                return 'Rp ' + rupiah;
            };

            // 🔹 Total dari detail service
            const getServiceTotal = () => Array.from(priceItems).reduce((acc, item) => {
                const val = parseInt(item.value.replace(/\D/g, '')) || 0;
                return acc + val;
            }, 0);

            // 🔹 Update semua nilai total
            const updateTotal = () => {
                const otherCost = parseInt(otherCostInput.value.replace(/\D/g, '')) || 0;
                const totalService = getServiceTotal();
                totalFromDB = totalService + otherCost;

                tableTotal.value = formatRupiah(totalService);
                totalCostInput.value = formatRupiah(totalFromDB);
                updatePayment();
            };

            // 🔹 Update status dan sisa bayar
            const updatePayment = () => {
                const paidNow = parseInt(paidInput.value.replace(/\D/g, '')) || 0;
                const totalPaid = initialPaid + paidNow;

                let remaining = Math.max(totalFromDB - totalPaid, 0);
                let status = 'unpaid';
                let change = 0;

                if (totalPaid >= totalFromDB && totalFromDB > 0) {
                    status = 'paid';
                    change = totalPaid - totalFromDB;
                } else if (totalPaid > 0 && totalPaid < totalFromDB) {
                    status = 'debt';
                }

                remainingInput.value = formatRupiah(remaining);
                changeInput.value = formatRupiah(change);
                statusPaidBadge.textContent = status.toUpperCase();
                statusPaidBadge.className = 'badge px-3 py-2 text-uppercase ' + (
                    status === 'paid' ? 'badge-success' :
                    status === 'debt' ? 'badge-warning' :
                    'badge-danger'
                );
            };

            // 🔹 Simpan Other Cost ke server
            const saveOtherCost = () => {
                const numericValue = otherCostInput.value.replace(/\D/g, '') || 0;
                fetch("{{ route('services.updateOtherCost', $service->id) }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            other_cost: numericValue
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            saveStatus.style.display = 'inline';
                            setTimeout(() => saveStatus.style.display = 'none', 1000);
                            updateTotal();
                        }
                    });
            };

            // 🔹 Submit Payment ke server
            submitBtn.addEventListener('click', e => {
                e.preventDefault();
                fetch("{{ route('services.updatePayment', $service->id) }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            paymentmethod: paymentMethod.value,
                            paid: paidInput.value.replace(/\D/g, '')
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update nilai dari server
                            initialPaid = data.paid ?? initialPaid;
                            totalFromDB = data.total ?? totalFromDB;

                            paidInput.value = 'Rp 0';
                            remainingInput.value = formatRupiah(data.remaining);
                            changeInput.value = formatRupiah(data.change);
                            statusPaidBadge.textContent = data.status.toUpperCase();
                            statusPaidBadge.className = 'badge px-3 py-2 text-uppercase ' + (
                                data.status === 'paid' ? 'badge-success' :
                                data.status === 'debt' ? 'badge-warning' :
                                'badge-danger'
                            );

                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Updated!',
                                text: 'Status pembayaran: ' + data.status.toUpperCase(),
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                window.location.href = "{{ route('services.index') }}";
                            });

                        } else {
                            Swal.fire('Error', 'Gagal memperbarui pembayaran', 'error');
                        }
                    }).catch(() => Swal.fire('Error', 'Terjadi kesalahan server', 'error'));
            });

            // 🔹 Format input Other Cost realtime
            otherCostInput.addEventListener('input', e => {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : 'Rp ';
                updateTotal();
            });

            otherCostInput.addEventListener('focus', e => {
                let numeric = e.target.value.replace(/\D/g, '');
                if (numeric === '0' || numeric === '') e.target.value = 'Rp ';
            });

            otherCostInput.addEventListener('blur', e => {
                let numeric = e.target.value.replace(/\D/g, '');
                e.target.value = numeric ? 'Rp ' + new Intl.NumberFormat('id-ID').format(numeric) : 'Rp 0';
                saveOtherCost();
            });

            otherCostInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    saveOtherCost();
                    otherCostInput.blur();
                }
            });

            // 🔹 Format input Paid realtime + selalu ada Rp
            paidInput.addEventListener('input', e => {
                let value = e.target.value.replace(/\D/g, '');
                paidInput.value = 'Rp ' + (value ? new Intl.NumberFormat('id-ID').format(value) : '0');
                updatePayment();
            });

            paidInput.addEventListener('focus', e => {
                let numeric = paidInput.value.replace(/\D/g, '');
                // Jika numeric 0 atau kosong, hapus angka tapi tetap ada Rp
                paidInput.value = 'Rp ' + (numeric && numeric !== '0' ? new Intl.NumberFormat('id-ID')
                    .format(numeric) : '');
            });

            paidInput.addEventListener('blur', e => {
                let numeric = paidInput.value.replace(/\D/g, '');
                paidInput.value = 'Rp ' + (numeric ? new Intl.NumberFormat('id-ID').format(numeric) : '0');
                updatePayment();
            });


            // 🔹 Inisialisasi awal
            updateTotal();
        });
    </script>
@endsection
