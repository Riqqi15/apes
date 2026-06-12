<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Direktur;
use App\Models\Hr;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthPageController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Username atau password salah.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath(Auth::user()));
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:191', 'unique:users,username'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
            'role' => ['required', 'in:hr,direktur,karyawan'],
        ]);

        DB::transaction(function () use ($validated): void {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'akses_user' => $validated['role'],
            ]);

            match ($validated['role']) {
                'hr' => Hr::create([
                    'nama_hr' => $validated['full_name'],
                    'jabatan' => 'HR Department',
                    'email' => $validated['email'],
                    'id_users' => $user->id_users,
                ]),
                'direktur' => Direktur::create([
                    'nama_direktur' => $validated['full_name'],
                    'jabatan' => 'Direktur',
                    'email' => $validated['email'],
                    'id_users' => $user->id_users,
                ]),
                'karyawan' => Karyawan::create([
                    'id_users' => $user->id_users,
                    'nip' => 'EMP-' . str_pad((string) $user->id_users, 4, '0', STR_PAD_LEFT),
                    'nama_lengkap' => $validated['full_name'],
                ]),
            };
        });

        return redirect()
            ->route('login')
            ->with('status', 'Akun berhasil dibuat. Silakan login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectPath(?User $user): string
    {
        return match ($user?->akses_user) {
            'hr' => route('dashboard.hr', absolute: false),
            'direktur' => route('dashboard.direktur', absolute: false),
            default => route('dashboard.karyawan', absolute: false),
        };
    }
}
