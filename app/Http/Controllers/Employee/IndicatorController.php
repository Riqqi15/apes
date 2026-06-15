<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Variabel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IndicatorController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $variableId = $request->integer('variable');
        $editingIndicator = $request->integer('edit')
            ? Indikator::with('variabel')->find($request->integer('edit'))
            : null;

        $variables = Variabel::query()
            ->withCount('indikator')
            ->orderBy('nama_variabel')
            ->get();

        $indicators = Indikator::query()
            ->with('variabel')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama_indikator', 'like', "%{$search}%")
                        ->orWhere('nama_variabel_penilaian', 'like', "%{$search}%");
                });
            })
            ->when($variableId > 0, fn ($query) => $query->where('id_variabel', $variableId))
            ->orderBy('id_variabel')
            ->orderBy('nama_indikator')
            ->paginate(10)
            ->withQueryString();

        return view('indicators.index', [
            'indicators' => $indicators,
            'variables' => $variables,
            'editingIndicator' => $editingIndicator,
            'filters' => [
                'search' => $search,
                'variable' => $variableId > 0 ? $variableId : null,
            ],
            'indicatorStats' => [
                'total' => Indikator::query()->count(),
                'filtered' => $indicators->total(),
                'withoutAlias' => Indikator::query()->whereNull('nama_variabel_penilaian')->count(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Indikator::create($this->validatedPayload($request));

        return redirect()
            ->route('kelola.indikator')
            ->with('status', 'Indikator penilaian berhasil ditambahkan.');
    }

    public function update(Request $request, Indikator $indikator): RedirectResponse
    {
        $indikator->update($this->validatedPayload($request, $indikator));

        return redirect()
            ->route('kelola.indikator')
            ->with('status', 'Indikator penilaian berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator): RedirectResponse
    {
        $indikator->delete();

        return redirect()
            ->route('kelola.indikator')
            ->with('status', 'Indikator penilaian berhasil dihapus.');
    }

    private function validatedPayload(Request $request, ?Indikator $indikator = null): array
    {
        $validated = $request->validate([
            'id_variabel' => ['required', 'integer', 'exists:variabel,id_variabel'],
            'nama_indikator' => [
                'required',
                'string',
                'max:255',
                Rule::unique('indikator', 'nama_indikator')
                    ->where(fn ($query) => $query->where('id_variabel', (int) $request->input('id_variabel')))
                    ->ignore($indikator?->id_indikator, 'id_indikator'),
            ],
            'nama_variabel_penilaian' => ['nullable', 'string', 'max:255'],
        ]);

        if (blank($validated['nama_variabel_penilaian'] ?? null)) {
            $validated['nama_variabel_penilaian'] = Variabel::query()
                ->where('id_variabel', $validated['id_variabel'])
                ->value('nama_variabel');
        }

        return $validated;
    }
}
