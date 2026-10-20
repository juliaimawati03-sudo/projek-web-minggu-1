<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordRequestController extends Controller
{
    /**
     * Tampilkan daftar permintaan reset password.
     */
    public function index()
    {
        $requests = PasswordRequest::with('resolver')
            ->orderByRaw("FIELD(status, 'pending', 'selesai', 'ditolak')")
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = PasswordRequest::where('status', 'pending')->count();

        return view('admin.password-request.index', compact('requests', 'pendingCount'));
    }

    /**
     * Reset password user berdasarkan permintaan.
     */
    public function reset(Request $request, $id)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:6',
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min'      => 'Password minimal 6 karakter.',
        ]);

        $passwordRequest = PasswordRequest::findOrFail($id);
        $user = User::where('username', $passwordRequest->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'User tidak ditemukan.']);
        }

        // Update password user (auto-hash via cast)
        $user->password = $validated['new_password'];
        $user->save();

        // Update status permintaan
        $passwordRequest->update([
            'status'      => 'selesai',
            'resolved_at' => now(),
            'resolved_by' => Auth::id(),
        ]);

        return redirect()->route('admin.password-request.index')
            ->with('success', "Password user <strong>{$user->username}</strong> berhasil direset menjadi: <strong>{$validated['new_password']}</strong>. Beritahu user via WhatsApp.");
    }

    /**
     * Tolak permintaan.
     */
    public function reject($id)
    {
        $passwordRequest = PasswordRequest::findOrFail($id);

        $passwordRequest->update([
            'status'      => 'ditolak',
            'resolved_at' => now(),
            'resolved_by' => Auth::id(),
        ]);

        return redirect()->route('admin.password-request.index')
            ->with('success', 'Permintaan reset password ditolak.');
    }
}