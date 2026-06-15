<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Variabel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VariableController extends Controller
{
    public function index(Request $request): View
    {
        $editingVariable = $request->integer('edit')
            ? Variabel::withCount('indikator')->find($request->integer('edit'))
            : null;

        $variables = Variabel::query()
            ->withCount('indikator')
            ->orderBy('nama_variabel')
            ->paginate(8)
            ->withQueryString();

        $totalIndicators = Indikator::query()->count();

        return view('variables.index', [
            'variables' => $variables,
            'editingVariable' => $editingVariable,
            'variableStats' => [
                'total' => $variables->total(),
                'totalIndicators' => $totalIndicators,
                'averageIndicators' => $variables->total() > 0
                    ? round($totalIndicators / $variables->total(), 1)
                    : 0,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Variabel::create($this->validateVariable($request));

        return redirect()
            ->route('kelola.variabel')
            ->with('status', 'Variabel AKHLAK berhasil ditambahkan.');
    }

    public function update(Request $request, Variabel $variabel): RedirectResponse
    {
        $variabel->update($this->validateVariable($request, $variabel));

        return redirect()
            ->route('kelola.variabel')
            ->with('status', 'Variabel AKHLAK berhasil diperbarui.');
    }

    public function destroy(Variabel $variabel): RedirectResponse
    {
        $deletedIndicators = $variabel->indikator()->count();
        $variabel->delete();

        return redirect()
            ->route('kelola.variabel')
            ->with('status', $deletedIndicators > 0
                ? "Variabel berhasil dihapus beserta {$deletedIndicators} indikator terkait."
                : 'Variabel AKHLAK berhasil dihapus.');
    }

    private function validateVariable(Request $request, ?Variabel $variabel = null): array
    {
        return $request->validate([
            'nama_variabel' => [
                'required',
                'string',
                'max:50',
                Rule::unique('variabel', 'nama_variabel')->ignore($variabel?->id_variabel, 'id_variabel'),
            ],
        ]);
    }
}
