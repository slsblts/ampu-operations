<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        $inventories = $query->orderBy('nama_alat', 'asc')->get();

        $totalUnit = Inventory::sum('stok_total');
        $totalTersedia = Inventory::sum('stok_tersedia');
        $totalDipinjam = max(0, $totalUnit - $totalTersedia);

        return view('inventori.index', compact(
            'inventories',
            'totalUnit',
            'totalTersedia',
            'totalDipinjam'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        $validated['stok_tersedia'] = $validated['stok_total'];

        Inventory::create($validated);

        return redirect()->route('inventori.index')
            ->with('success', 'Alat baru berhasil ditambahkan ke daftar inventori.');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'stok_tersedia' => 'required|integer|min:0|lte:stok_total',
            'kondisi' => 'required|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventori.index')
            ->with('success', 'Data inventori berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventori.index')
            ->with('success', 'Alat berhasil dihapus dari daftar inventori.');
    }
}