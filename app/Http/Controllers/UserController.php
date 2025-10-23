<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true, 'status' => $user->status]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datauser = User::paginate(3);
        return view('pages.user.index', compact('datauser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $datauser = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' =>  $request->role,
        ];

        if ($request->hasFile('photo')) {
            $datauser['photo'] = $request->file('photo')->store('images_user', 'public');
        }

        User::create($datauser);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.user.show', compact('user'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datauser = User::find($id);

        // Kalau data tidak ditemukan → 404
        if (!$datauser) {
            abort(404);
        }

        // Kalau sebelumnya sudah ada session ID dan beda → arahkan ke 403
        if (session()->has('allowed_edit_id') && session('allowed_edit_id') != $id) {
            return redirect()->route('error403');
        }

        // Simpan ID dan nama route terakhir yang diizinkan untuk diedit
        session([
            'allowed_edit_id' => $id,
            'last_edit_id' => $id,
            'last_edit_route' => 'user.edit',
        ]);

        return view('pages.user.edit', compact('datauser'));
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

        $datauser = User::find($id);

        // Kalau data gak ada → 404
        if (!$datauser) {
            abort(404);
        }

        $datauser = User::find($id);

        if ($datauser == null) {
            return redirect()->route('user.index');
        }

        $updateData = $request->only(['name', 'address', 'phone_number', 'email', 'role']);
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('photo')) {
            if ($datauser->photo && Storage::disk('public')->exists($datauser->photo)) {
                Storage::disk('public')->delete($datauser->photo);
            }
            $updateData['photo'] = $request->file('photo')->store('images_user', 'public');
        }
        $datauser->save($updateData);

        session()->forget('allowed_edit_id');


        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datauser = User::find($id);

        if (!$datauser) {
            return redirect()->route('user.index');
        }

        // Hapus foto dari storage jika ada
        if ($datauser->photo && Storage::disk('public')->exists($datauser->photo)) {
            Storage::disk('public')->delete($datauser->photo);
        }

        // Hapus data user
        $datauser->delete();

        return redirect()->route('user.index');
    }
}
