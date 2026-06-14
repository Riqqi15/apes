<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\AssessorAssignment;
use App\Models\Indikator;
use App\Models\Karyawan;
use App\Models\PeriodePenilaian;
use App\Models\RekapPenilaian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    public function periods(Request $request): View
    {
        $editingPeriod = $request->integer('edit_period')
            ? PeriodePenilaian::find($request->integer('edit_period'))
            : null;
        $editingAssignment = $request->integer('edit_assignment')
            ? AssessorAssignment::find($request->integer('edit_assignment'))
            : null;

        $periods = PeriodePenilaian::query()
            ->withCount('assignments')
            ->orderByDesc('tanggal_mulai')
            ->get();

        $employees = Karyawan::query()
            ->orderBy('nama_lengkap')
            ->get();

        $assignments = AssessorAssignment::query()
            ->with(['period', 'assessor', 'assessee'])
            ->orderByDesc('created_at')
            ->get();

        return view('assessments.periods', [
            'periods' => $periods,
            'employees' => $employees,
            'assignments' => $assignments,
            'editingPeriod' => $editingPeriod,
            'editingAssignment' => $editingAssignment,
            'periodStats' => [
                'total' => $periods->count(),
                'active' => $periods->where('status', 'active')->count(),
                'closed' => $periods->where('status', 'closed')->count(),
            ],
            'assignmentStats' => [
                'total' => $assignments->count(),
                'waiting' => $assignments->where('status', 'Menunggu')->count(),
                'completed' => $assignments->where('status', 'Selesai')->count(),
            ],
            'roleTypes' => $this->roleTypes(),
            'statusOptions' => $this->assignmentStatuses(),
        ]);
    }

    public function storePeriod(Request $request): RedirectResponse
    {
        PeriodePenilaian::create($this->validatePeriod($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil ditambahkan.');
    }

    public function updatePeriod(Request $request, PeriodePenilaian $periode): RedirectResponse
    {
        $periode->update($this->validatePeriod($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil diperbarui.');
    }

    public function destroyPeriod(PeriodePenilaian $periode): RedirectResponse
    {
        $periode->delete();

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil dihapus.');
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        AssessorAssignment::create($this->validateAssignment($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil ditambahkan.');
    }

    public function updateAssignment(Request $request, AssessorAssignment $assignment): RedirectResponse
    {
        $assignment->update($this->validateAssignment($request, $assignment));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil diperbarui.');
    }

    public function destroyAssignment(AssessorAssignment $assignment): RedirectResponse
    {
        $assignment->delete();

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil dihapus.');
    }

    public function assignments(): View
    {
        $employeeId = auth()->user()?->karyawan?->id_karyawan;

        $assignments = AssessorAssignment::query()
            ->with(['period', 'assessor', 'assessee'])
            ->when($employeeId, fn ($query) => $query->where('assessor_id', $employeeId))
            ->orderByDesc('created_at')
            ->get();

        return view('assessments.assignments', [
            'assignments' => $assignments,
        ]);
    }

    public function form(): View
    {
        $periods = PeriodePenilaian::query()->orderByDesc('tanggal_mulai')->get();
        $employees = Karyawan::query()->orderBy('nama_lengkap')->get();
        $indicators = Indikator::query()->with('variabel')->orderBy('id_variabel')->get();

        return view('assessments.form', [
            'periods' => $periods,
            'employees' => $employees,
            'roleTypes' => $this->roleTypes(),
            'indicators' => $indicators,
        ]);
    }

    public function personalResult(): View
    {
        $employeeId = auth()->user()?->karyawan?->id_karyawan;
        $latestRecap = $employeeId
            ? RekapPenilaian::query()->where('id_karyawan', $employeeId)->latest()->first()
            : null;

        return view('assessments.personal-result', [
            'latestRecap' => $latestRecap,
        ]);
    }

    private function validatePeriod(Request $request): array
    {
        return $request->validate([
            'nama_periode' => ['required', 'string', 'max:60'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', Rule::in(['draft', 'active', 'closed'])],
        ]);
    }

    private function validateAssignment(Request $request, ?AssessorAssignment $assignment = null): array
    {
        $validated = $request->validate([
            'id_periode' => ['required', 'integer', 'exists:periode_penilaian,id_periode'],
            'assessor_id' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'assessee_id' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'jenis_penilai' => ['required', Rule::in($this->roleTypes())],
            'status' => ['required', Rule::in($this->assignmentStatuses())],
            'deadline' => ['nullable', 'date'],
        ]);

        $duplicate = AssessorAssignment::query()
            ->where('id_periode', $validated['id_periode'])
            ->where('assessor_id', $validated['assessor_id'])
            ->where('assessee_id', $validated['assessee_id'])
            ->where('jenis_penilai', $validated['jenis_penilai'])
            ->when($assignment, fn ($query) => $query->where('id_assignment', '!=', $assignment->id_assignment))
            ->exists();

        if ($validated['jenis_penilai'] === 'Self Assessment' && $validated['assessor_id'] !== $validated['assessee_id']) {
            throw ValidationException::withMessages([
                'assessee_id' => 'Self Assessment harus menggunakan assessor dan assessee yang sama.',
            ]);
        }

        if ($validated['jenis_penilai'] !== 'Self Assessment' && $validated['assessor_id'] === $validated['assessee_id']) {
            throw ValidationException::withMessages([
                'assessor_id' => 'Assessor dan assessee harus berbeda untuk tipe penilai ini.',
            ]);
        }

        if ($duplicate) {
            throw ValidationException::withMessages([
                'jenis_penilai' => 'Assignment dengan kombinasi periode, assessor, assessee, dan tipe ini sudah ada.',
            ]);
        }

        return $validated;
    }

    private function roleTypes(): array
    {
        return [
            'Atasan Langsung',
            'Rekan Sejawat',
            'Bawahan',
            'Self Assessment',
        ];
    }

    private function assignmentStatuses(): array
    {
        return [
            'Menunggu',
            'Berjalan',
            'Selesai',
        ];
    }
}
