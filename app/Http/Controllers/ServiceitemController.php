<?php

namespace App\Http\Controllers;

use App\Models\Serviceitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceitemController extends Controller
{
    public function toggleStatus(Request $request, $id)
    {
        $service = \App\Models\Serviceitem::findOrFail($id);
        $service->status = $request->status;
        $service->save();

        return response()->json([
            'success' => true,
            'status' => $service->status
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session()->forget('allowed_edit_id');
        $dataserviceitem = Serviceitem::paginate(3);
        return view('pages.serviceitem.index', compact('dataserviceitem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.serviceitem.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required',
            'price' => 'required',
        ]);

        // 🔹 Bersihkan format "Rp" dan titik sebelum disimpan
        $cleanPrice = str_replace(['Rp', '.', ' '], '', $request->price);
        $cleanPrice = (int) $cleanPrice;

        $dataserviceitem = [
            'service_name' => $request->service_name,
            'price' => $cleanPrice, // simpan angka bersih
        ];


        Serviceitem::create($dataserviceitem);

        return redirect()->route('serviceitem.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceitem = Serviceitem::find($id);

        if (!$serviceitem) {
            abort(404);
        }

        if (session()->has('allowed_edit_id') && session('allowed_edit_id') != $id) {
            return redirect()->route('error403');
        }

        session([
            'allowed_edit_id' => $id,
            'last_edit_id' => $id,
            'last_edit_route' => 'serviceitem.edit',
        ]);

        return view('pages.serviceitem.edit', compact('serviceitem'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $allowedId = session('allowed_edit_id');

        // Kalau user manipulasi URL → langsung ke 403
        if ($allowedId != $id) {
            return redirect()->route('error403');
        }

        $dataserviceitem = Serviceitem::find($id);

        // Kalau data gak ada → 404
        if (!$dataserviceitem) {
            abort(404);
        }

        // 🔹 Bersihkan format "Rp" dan titik
        $cleanPrice = str_replace(['Rp', '.', ' '], '', $request->price);
        $cleanPrice = (int) $cleanPrice;

        $request->validate([
            'service_name' => 'nullable',
            'price' => 'nullable',
        ]);

        // Update data
        $dataserviceitem->fill([
            'service_name' => $request->service_name,
            'price' => $cleanPrice,
        ]);

        $dataserviceitem->save();

        // Hapus session setelah update selesai
        session()->forget('allowed_edit_id');

        return redirect()->route('serviceitem.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
