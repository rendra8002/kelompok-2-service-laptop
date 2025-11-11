<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class LaptopController extends Controller
{
    public function toggleStatus(Request $request, $id)
    {
        $laptop = Laptop::find($id);

        if (!$laptop) {
            return response()->json(['success' => false]);
        }

        $laptop->status = $request->status;
        $laptop->save();

        return response()->json([
            'success' => true,
            'status' => $laptop->status,
        ]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session()->forget('allowed_edit_id');

        // Ambil data laptop dari database
        $datalaptop = Laptop::paginate(10);

        // Kirim ke view laptop.index
        return view('pages.laptop.index', compact('datalaptop'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.laptop.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'release_year' => 'required',
        ]);

        // 🔍 Cek apakah model sudah ada
        $existing = Laptop::where('model', $request->model)->first();
        if ($existing) {
         
            return redirect()
                ->back()
                ->withInput($request->except('model')) // Simpan input lain, kecuali model
                ->with('error', "' $request->model '" );
        }

        $datalaptop = [
            'brand' => $request->brand,
            'model' => $request->model,
            'release_year' => $request->release_year,
        ];

        if ($request->hasFile('photo')) {
            $datalaptop['photo'] = $request->file('photo')->store('images_laptop', 'public');
        }

        Laptop::create($datalaptop);

        return redirect()
            ->route('laptop.index')
            ->with('success', 'Laptop data has been added successfully');
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
        $datalaptop = Laptop::find($id);

        if (!$datalaptop) {
            abort(404);
        }

        if (session()->has('allowed_edit_id') && session('allowed_edit_id') != $id) {
            return redirect()->route('error403');
        }

        // Simpan ID dan nama route terakhir yang diizinkan untuk diedit
        session([
            'allowed_edit_id' => $id,
            'last_edit_id' => $id,
            'last_edit_route' => 'laptop.edit',
        ]);

        return view('pages.laptop.edit', compact('datalaptop'));
    }



    public function update(Request $request, string $id)
    {
        $allowedId = session('allowed_edit_id');

        // Kalau user manipulasi URL → langsung ke 403
        if ($allowedId != $id) {
            return redirect()->route('error403');
        }

        $datalaptop = Laptop::find($id);

        // Kalau data gak ada → 404
        if (!$datalaptop) {
            abort(404);
        }

        $request->validate([
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'release_year' => 'nullable|string',
            'photo' => 'nullable|image',
        ]);

        // Update data
        $datalaptop->fill($request->only(['brand', 'model', 'release_year']));

        if ($request->hasFile('photo')) {
            if ($datalaptop->photo && Storage::disk('public')->exists($datalaptop->photo)) {
                Storage::disk('public')->delete($datalaptop->photo);
            }
            $datalaptop->photo = $request->file('photo')->store('images_laptop', 'public');
        }

        $datalaptop->save();

        // Hapus session setelah update selesai
        session()->forget('allowed_edit_id');

        return redirect()->route('laptop.index')->with('success', 'Data berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datalaptop = Laptop::find($id);

        if (!$datalaptop) {
            return redirect()->route('laptop.index')->with('error', 'Laptop not found.');
        }

        // Soft delete data laptop saja
        $datalaptop->delete();

        return redirect()->route('laptop.index')->with('success', 'Laptop deleted successfully.');
    }
}
