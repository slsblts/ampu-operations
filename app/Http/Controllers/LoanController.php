<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\StudioBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $activeLoans = Loan::with(['items.inventory', 'issuedBy'])
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        $inventories = Inventory::where('stok_tersedia', '>', 0)
            ->where('kondisi', '!=', 'Rusak')
            ->orderBy('nama_alat', 'asc')
            ->get();

        return view('logbook.index', compact('activeLoans', 'inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nim_nik' => 'required|string|max:100',
            'no_hp' => 'required|string|max:50',
            'organisasi' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'nullable|exists:inventori,id',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        foreach ($request->items as $item) {
            $inventory = !empty($item['inventory_id'])
                ? Inventory::find($item['inventory_id'])
                : Inventory::where('nama_alat', trim($item['name']))->first();

            if ($inventory && $item['qty'] > $inventory->stok_tersedia) {
                return back()
                    ->withInput()
                    ->withErrors(['items' => "Stok {$inventory->nama_alat} tidak mencukupi (tersedia: {$inventory->stok_tersedia} unit)."]);
            }
        }

        DB::transaction(function () use ($request) {
            $loan = Loan::create([
                'nama_peminjam' => $request->nama_peminjam,
                'nim_nik' => $request->nim_nik,
                'no_hp' => $request->no_hp,
                'organisasi' => $request->organisasi,
                'keperluan' => $request->keperluan,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'dipinjam',
                'admin_pinjam_id' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                $inventory = !empty($item['inventory_id'])
                    ? Inventory::find($item['inventory_id'])
                    : Inventory::where('nama_alat', trim($item['name']))->first();

                LoanItem::create([
                    'peminjaman_id' => $loan->id,
                    'inventori_id' => $inventory?->id,
                    'nama_barang' => $inventory ? $inventory->nama_alat : trim($item['name']),
                    'jumlah' => $item['qty'],
                ]);

                if ($inventory) {
                    $inventory->decrement('stok_tersedia', $item['qty']);
                }
            }
        });

        return redirect()->route('logbook.index')->with('success', 'Peminjaman berhasil dicatat & stok inventori diperbarui.');
    }

    public function returnItem(Request $request, Loan $loan)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_kembali' => 'required|string|max:100',
            'catatan_kembali' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $loan) {
            if ($loan->status === 'dipinjam') {
                $loan->load('items.inventory');

                foreach ($loan->items as $item) {
                    if ($item->inventory) {
                        $newStock = min(
                            $item->inventory->stok_total,
                            $item->inventory->stok_tersedia + $item->jumlah
                        );
                        $item->inventory->update(['stok_tersedia' => $newStock]);
                    }
                }
            }

            $loan->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dikembalikan',
                'kondisi_kembali' => $request->kondisi_kembali,
                'catatan_kembali' => $request->catatan_kembali,
                'admin_kembali_id' => Auth::id(),
            ]);
        });

        return redirect()->route('logbook.index')->with('success', 'Alat telah dikonfirmasi kembali & stok inventori dipulihkan.');
    }

    public function history(Request $request)
    {
        $tab = $request->get('tab', 'alat');

        $loanQuery = Loan::with(['items', 'issuedBy', 'receivedBy'])
            ->where('status', 'dikembalikan');

        if ($request->filled('search') && $tab === 'alat') {
            $search = $request->search;
            $loanQuery->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', "%{$search}%")
                  ->orWhere('nim_nik', 'like', "%{$search}%")
                  ->orWhere('organisasi', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhereHas('items', fn($q2) => $q2->where('nama_barang', 'like', "%{$search}%"));
            });
        }

        if ($request->filter === 'today') {
            $loanQuery->whereDate('tanggal_kembali', today());
        } elseif ($request->filter === 'week') {
            $loanQuery->whereBetween('tanggal_kembali', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $returnedLoans = $loanQuery->latest('tanggal_kembali')->get();

        $studioQuery = StudioBooking::with('createdBy')
            ->whereIn('status', ['selesai', 'dibatalkan']);

        if ($request->filled('search') && $tab === 'studio') {
            $search = $request->search;
            $studioQuery->where(function ($q) use ($search) {
                $q->where('nama_studio', 'like', "%{$search}%")
                  ->orWhere('nama_acara', 'like', "%{$search}%")
                  ->orWhere('pic_kru', 'like', "%{$search}%");
            });
        }

        if ($request->filter === 'today') {
            $studioQuery->whereDate('tanggal_booking', today());
        } elseif ($request->filter === 'week') {
            $studioQuery->whereBetween('tanggal_booking', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $completedBookings = $studioQuery->latest('tanggal_booking')->get();

        return view('riwayat.index', compact('returnedLoans', 'completedBookings', 'tab'));
    }

    public function exportCsv(Request $request)
    {
        $tab = $request->get('tab', 'alat');

        if ($tab === 'studio') {
            $bookings = StudioBooking::with('createdBy')
                ->whereIn('status', ['selesai', 'dibatalkan'])
                ->latest('tanggal_booking')
                ->get();

            $filename = 'riwayat-studio-ampu-' . now()->format('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($bookings) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Tanggal', 'Studio', 'Nama Acara / Proyek', 'PIC / Kru', 'Jam / Sesi', 'Status', 'Dicatat Oleh']);

                foreach ($bookings as $booking) {
                    fputcsv($file, [
                        $booking->tanggal_booking,
                        $booking->nama_studio,
                        $booking->nama_acara,
                        $booking->pic_kru,
                        $booking->sesi_jam,
                        $booking->status === 'selesai' ? 'Selesai' : 'Dibatalkan',
                        $booking->createdBy->name ?? '-',
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $loans = Loan::with(['items', 'issuedBy', 'receivedBy'])
            ->where('status', 'dikembalikan')
            ->latest('tanggal_kembali')
            ->get();

        $filename = 'riwayat-logbook-ampu-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($loans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal Pinjam', 'Tanggal Kembali', 'Nama Peminjam', 'NIM/NIK', 'No. HP', 'Organisasi/Divisi', 'Keperluan/Acara', 'Barang & Jumlah', 'Kondisi Kembali', 'Catatan', 'Mengetahui Pinjam', 'Diterima Kembali']);

            foreach ($loans as $loan) {
                $itemsText = $loan->items->map(fn($i) => "{$i->nama_barang} ({$i->jumlah})")->implode(', ');
                fputcsv($file, [
                    $loan->tanggal_pinjam,
                    $loan->tanggal_kembali,
                    $loan->nama_peminjam,
                    $loan->nim_nik,
                    $loan->no_hp,
                    $loan->organisasi,
                    $loan->keperluan,
                    $itemsText,
                    $loan->kondisi_kembali,
                    $loan->catatan_kembali,
                    $loan->issuedBy->name ?? '-',
                    $loan->receivedBy->name ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}