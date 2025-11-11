<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function index()
    {
        session()->forget('allowed_edit_id');

        $datauser = User::paginate(7);
        return view('pages.user.index', compact('datauser'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email', // HAPUS rule unique
            'password' => 'required',
        ]);


        try {
            // cek email duplikat manual juga (optional safety check)
            $existing = User::where('email', $request->email)->first();
            if ($existing) {
                return redirect()
                    ->back()
                    ->withInput($request->except('email')) // simpan input lain, kosongkan email
                    ->with('error', 'duplicate_email');
            }

            $datauser = [
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ];

            if ($request->hasFile('photo')) {
                $datauser['photo'] = $request->file('photo')->store('images_user', 'public');
            }

            User::create($datauser);

            return redirect()->route('user.index')
                ->with('success', 'User data has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create user. Please try again!');
        }
    }



    public function show(User $user)
    {
        return view('pages.user.show', compact('user'));
    }

    public function edit(string $id)
    {
        $datauser = User::find($id);
        if (!$datauser) {
            abort(404);
        }

        session([
            'allowed_edit_id' => $id,
            'last_edit_id' => $id,
            'last_edit_route' => 'user.edit',
        ]);

        return view('pages.user.edit', compact('datauser'));
    }

    public function update(Request $request, string $id)
    {
        $allowedId = session('allowed_edit_id');
        if ($allowedId != $id) {
            return redirect()->route('error403');
        }

        $datauser = User::find($id);
        if (!$datauser) {
            abort(404);
        }

        try {
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

            $datauser->update($updateData);

            session()->forget('allowed_edit_id');

            return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $datauser = User::find($id);

            if (!$datauser) {
                return redirect()->route('user.index')->with('error', 'User tidak ditemukan.');
            }

            // ❌ Jangan hapus foto dulu, cukup soft delete data
            $datauser->delete();

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus (soft delete)!');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
