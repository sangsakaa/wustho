<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LembagaController extends Controller
{
    public function index(Request $request)
    {
        $query = Lembaga::query();

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        });

        $lembagas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.lembaga.index', compact('lembagas'));
    }
    public function show(Lembaga $lembaga)
    {
        return view('admin.lembaga.show', compact('lembaga'));
    }

    public function create()
    {
        return view('admin.lembaga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:lembagas,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated) {

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')
                    ->store('lembaga-logo', 'public');
            }

            Lembaga::create($validated);
        });

        return redirect()
            ->route('lembaga.index')
            ->with('success', 'Lembaga berhasil ditambahkan');
    }

    public function edit(Lembaga $lembaga)
    {
        return view('admin.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, Lembaga $lembaga)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:lembagas,kode,' . $lembaga->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated, $lembaga) {

            if ($request->hasFile('logo')) {

                if ($lembaga->logo && Storage::disk('public')->exists($lembaga->logo)) {
                    Storage::disk('public')->delete($lembaga->logo);
                }

                $validated['logo'] = $request->file('logo')
                    ->store('lembaga-logo', 'public');
            }

            $lembaga->update($validated);
        });

        return redirect()
            ->route('lembaga.index')
            ->with('success', 'Lembaga berhasil diperbarui');
    }

    public function destroy(Lembaga $lembaga)
    {
        DB::transaction(function () use ($lembaga) {

            if ($lembaga->logo && Storage::disk('public')->exists($lembaga->logo)) {
                Storage::disk('public')->delete($lembaga->logo);
            }

            $lembaga->delete();
        });

        return back()->with('success', 'Lembaga berhasil dihapus');
    }

    public function toggle(Lembaga $lembaga)
    {
        $lembaga->update([
            'is_active' => !$lembaga->is_active
        ]);

        return back()->with('success', 'Status lembaga berhasil diperbarui');
    }
}
