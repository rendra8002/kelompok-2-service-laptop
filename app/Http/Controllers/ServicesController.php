<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Laptop;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Servicedetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function updateStatus(Request $request, Service $service)
    {
        $request->validate([
            'status' => 'required|in:accepted,process,finished,taken,canceled',
        ]);

        $status = $request->status;

        // Set tanggal otomatis
        if ($status === 'accepted' && !$service->received_date) {
            $service->received_date = now();
        }

        if ($status === 'finished' && !$service->completed_date) {
            $service->completed_date = now();
        }

        $service->status = $status;
        $service->save();

        return response()->json(['success' => true]);
    }



    // 🔹 Update Pembayaran
    public function updatePayment(Request $request, $id)
    {
        $service = Service::with('details')->findOrFail($id);

        // Hitung total harga + biaya tambahan
        $total = ($service->details->sum('price') ?? 0) + ($service->other_cost ?? 0);

        // Ambil paid lama
        $paidOld = $service->paid ?? 0;

        // Ambil input paid baru
        $paidInput = (int) preg_replace('/\D/', '', $request->paid ?? 0);

        // Total paid = paid lama + paid input baru
        $paid = $paidOld + $paidInput;

        // Tentukan status pembayaran
        if ($paid >= $total && $total > 0) {
            $status = 'paid';
        } elseif ($paid > 0 && $paid < $total) {
            $status = 'debt';
        } else {
            $status = 'unpaid';
        }

        // Simpan data
        $service->update([
            'paymentmethod' => $request->paymentmethod ?? $service->paymentmethod,
            'paid' => $paid,
            'change' => $paid > $total ? $paid - $total : 0,
            'status_paid' => $status,
        ]);

        return response()->json([
            'success' => true,
            'status' => $status,
            'paid' => $paid,
            'remaining' => max($total - $paid, 0),
            'change' => max($paid - $total, 0),
        ]);
    }



    // 🔹 Update Biaya Lain-lain (Other Cost)
    public function updateOtherCost(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Ambil angka saja dari input
        $otherCost = (int) preg_replace('/\D/', '', $request->other_cost ?? '0');

        $service->other_cost = $otherCost;
        $service->save();

        return response()->json([
            'success' => true,
            'other_cost' => $otherCost,
        ]);
    }

    // 🔹 List Semua Service
    public function index()
    {
        $services = Service::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.services.index', compact('services'));
    }

    // 🔹 Form Tambah Service
    public function create()
    {
        $customers = User::where('role', 'customer')->where('status', 'active')->get();
        $technicians = User::where('role', 'technician')->where('status', 'active')->get();
        $laptops = Laptop::all();
        $serviceTypes = ServiceItem::where('status', 'active')->get();

        // 🔹 Generate nomor invoice otomatis (tidak menambah data)
        $lastInvoice = Service::orderBy('id', 'desc')->first();
        $newNumber = $lastInvoice ? intval(substr($lastInvoice->no_invoice, -4)) + 1 : 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return view('pages.services.create', compact('customers', 'technicians', 'laptops', 'serviceTypes', 'no_invoice'));
    }


    // 🔹 Simpan Service Baru
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'customer_id' => 'required|exists:users,id',
                'technician_id' => 'required|exists:users,id',
                'laptop_id' => 'required|exists:laptops,id',
                'damage_description' => 'required|string',
                'service_type' => 'required|array|min:1',
                'paid' => 'nullable',
            ]);

            $cleanOtherCost = (int) preg_replace('/\D/', '', $request->other_cost ?? '0');
            $totalServiceCost = 0;

            foreach ($request->price as $price) {
                $totalServiceCost += (int) preg_replace('/\D/', '', $price ?? 0);
            }

            $totalCost = $totalServiceCost + $cleanOtherCost;
            $paid = (int) preg_replace('/\D/', '', $request->paid ?? '0');
            $change = $paid > $totalCost ? $paid - $totalCost : 0;

            if ($paid == 0) {
                $statusPaid = 'unpaid';
            } elseif ($paid < $totalCost) {
                $statusPaid = 'debt';
            } else {
                $statusPaid = 'paid';
            }

            $service = Service::create([
                'no_invoice' => $request->no_invoice,
                'customer_id' => $request->customer_id,
                'technician_id' => $request->technician_id,
                'laptop_id' => $request->laptop_id,
                'damage_description' => $request->damage_description,
                'status' => 'process',
                'other_cost' => $cleanOtherCost,
                'total_cost' => $totalCost,
                'paid' => $paid,
                'change' => $change,
                'status_paid' => $statusPaid,
            ]);

            foreach ($request->service_type as $index => $type_id) {
                $price = (int) preg_replace('/\D/', '', $request->price[$index] ?? 0);
                Servicedetail::create([
                    'service_id' => $service->id,
                    'service_type_id' => $type_id,
                    'price' => $price,
                ]);
            }

            DB::commit();
            return redirect()->route('services.index')
                ->with('success', 'Service created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    // 🔹 Detail Service
    public function show(string $id)
    {
        $service = Service::with([
            'customer',
            'technician',
            'laptop',
            'details.serviceType'
        ])->findOrFail($id);

        return view('pages.services.show', compact('service'));
    }

    // Dummy CRUD ops
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
