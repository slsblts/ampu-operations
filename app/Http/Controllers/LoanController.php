<?php

namespace App\Http\Controllers;

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
        $activeLoans = Loan::with(['items', 'issuedBy'])
            ->where('status', 'borrowed')
            ->latest()
            ->get();

        return view('logbook.index', compact('activeLoans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_id_number' => 'required|string|max:100',
            'phone_number' => 'required|string|max:50',
            'organization' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $loan = Loan::create([
                'borrower_name' => $request->borrower_name,
                'borrower_id_number' => $request->borrower_id_number,
                'phone_number' => $request->phone_number,
                'organization' => $request->organization,
                'purpose' => $request->purpose,
                'borrow_date' => $request->borrow_date,
                'status' => 'borrowed',
                'issued_by_admin_id' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                LoanItem::create([
                    'loan_id' => $loan->id,
                    'item_name' => $item['name'],
                    'quantity' => $item['qty'],
                ]);
            }
        });

        return redirect()->route('logbook.index')->with('success', 'Peminjaman berhasil dicatat ke logbook.');
    }

    public function returnItem(Request $request, Loan $loan)
    {
        $request->validate([
            'return_date' => 'required|date',
            'return_condition' => 'required|string|max:100',
            'return_notes' => 'nullable|string',
        ]);

        $loan->update([
            'return_date' => $request->return_date,
            'status' => 'returned',
            'return_condition' => $request->return_condition,
            'return_notes' => $request->return_notes,
            'received_by_admin_id' => Auth::id(),
        ]);

        return redirect()->route('logbook.index')->with('success', 'Alat telah dikonfirmasi kembali & dipindahkan ke Riwayat.');
    }

    public function history(Request $request)
    {
        $tab = $request->get('tab', 'alat');

        // 1. Query Riwayat Peminjaman Alat
        $loanQuery = Loan::with(['items', 'issuedBy', 'receivedBy'])
            ->where('status', 'returned');

        if ($request->filled('search') && $tab === 'alat') {
            $search = $request->search;
            $loanQuery->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_id_number', 'like', "%{$search}%")
                  ->orWhere('organization', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhereHas('items', fn($q2) => $q2->where('item_name', 'like', "%{$search}%"));
            });
        }

        if ($request->filter === 'today') {
            $loanQuery->whereDate('return_date', today());
        } elseif ($request->filter === 'week') {
            $loanQuery->whereBetween('return_date', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $returnedLoans = $loanQuery->latest('return_date')->get();

        // 2. Query Riwayat Peminjaman Studio (completed & cancelled)
        $studioQuery = StudioBooking::with('createdBy')
            ->whereIn('status', ['completed', 'cancelled']);

        if ($request->filled('search') && $tab === 'studio') {
            $search = $request->search;
            $studioQuery->where(function ($q) use ($search) {
                $q->where('studio_name', 'like', "%{$search}%")
                  ->orWhere('project_name', 'like', "%{$search}%")
                  ->orWhere('pic_crew', 'like', "%{$search}%");
            });
        }

        if ($request->filter === 'today') {
            $studioQuery->whereDate('booking_date', today());
        } elseif ($request->filter === 'week') {
            $studioQuery->whereBetween('booking_date', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $completedBookings = $studioQuery->latest('booking_date')->get();

        return view('riwayat.index', compact('returnedLoans', 'completedBookings', 'tab'));
    }

    public function exportCsv(Request $request)
    {
        $tab = $request->get('tab', 'alat');

        if ($tab === 'studio') {
            $bookings = StudioBooking::with('createdBy')
                ->whereIn('status', ['completed', 'cancelled'])
                ->latest('booking_date')
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
                        $booking->booking_date,
                        $booking->studio_name,
                        $booking->project_name,
                        $booking->pic_crew,
                        $booking->time_slot,
                        $booking->status === 'completed' ? 'Selesai' : 'Dibatalkan',
                        $booking->createdBy->name ?? '-',
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $loans = Loan::with(['items', 'issuedBy', 'receivedBy'])
            ->where('status', 'returned')
            ->latest('return_date')
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
                $itemsText = $loan->items->map(fn($i) => "{$i->item_name} ({$i->quantity})")->implode(', ');
                fputcsv($file, [
                    $loan->borrow_date,
                    $loan->return_date,
                    $loan->borrower_name,
                    $loan->borrower_id_number,
                    $loan->phone_number,
                    $loan->organization,
                    $loan->purpose,
                    $itemsText,
                    $loan->return_condition,
                    $loan->return_notes,
                    $loan->issuedBy->name ?? '-',
                    $loan->receivedBy->name ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}