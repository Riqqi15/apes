<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $department = trim((string) $request->string('department'));

        $employees = Karyawan::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%")
                        ->orWhere('departemen', 'like', "%{$search}%");
                });
            })
            ->when($department !== '', fn ($query) => $query->where('departemen', $department))
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        $departments = Karyawan::query()
            ->select('departemen')
            ->whereNotNull('departemen')
            ->distinct()
            ->orderBy('departemen')
            ->pluck('departemen');

        return view('employees.index', [
            'employees' => $employees,
            'departments' => $departments,
            'filters' => [
                'search' => $search,
                'department' => $department,
            ],
        ]);
    }

    public function create(): View
    {
        return view('employees.create', [
            'employee' => $this->blankEmployee(),
            'formAction' => route('kelola.karyawan.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Karyawan::create($this->validateEmployee($request));

        return redirect()
            ->route('kelola.karyawan')
            ->with('status', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id = null): View
    {
        $employee = $id
            ? Karyawan::findOrFail($id)
            : Auth::user()?->karyawan;

        abort_if(! $employee, 404);

        return view('employees.edit', [
            'employee' => $employee,
            'formAction' => $id
                ? route('kelola.karyawan.update', $employee->id_karyawan)
                : route('biodata.update'),
            'formMethod' => 'PUT',
            'backRoute' => $id ? route('kelola.karyawan') : route('dashboard.karyawan'),
            'isProfileEdit' => ! $id,
        ]);
    }

    public function update(Request $request, $id = null): RedirectResponse
    {
        $employee = $id
            ? Karyawan::findOrFail($id)
            : Auth::user()?->karyawan;

        abort_if(! $employee, 404);

        $employee->update($this->validateEmployee($request, $employee));

        return redirect()
            ->route($id ? 'kelola.karyawan' : 'biodata.edit')
            ->with('status', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        Karyawan::findOrFail($id)->delete();

        return redirect()
            ->route('kelola.karyawan')
            ->with('status', 'Data karyawan berhasil dihapus.');
    }

    private function blankEmployee(): object
    {
        return (object) [
            'nama_lengkap' => '',
            'nip' => '',
            'departemen' => '',
            'jabatan' => '',
            'no_hp' => '',
            'tanggal_lahir' => null,
            'alamat' => '',
        ];
    }

    private function validateEmployee(Request $request, ?Karyawan $employee = null): array
    {
        return $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nip' => [
                'required',
                'string',
                'max:40',
                Rule::unique('karyawan', 'nip')->ignore($employee?->id_karyawan, 'id_karyawan'),
            ],
            'departemen' => ['nullable', 'string', 'max:100'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
