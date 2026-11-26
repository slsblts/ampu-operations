<?php

namespace App\Http\Controllers;

use App\Models\StudioBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioBookingController extends Controller
{
    public function index()
    {
        $bookings = StudioBooking::whereIn('status', ['terjadwal', 'dikonfirmasi'])
            ->orderBy('tanggal_booking')
            ->get();

        return view('jadwal.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_studio' => 'required|string|max:100',
            'nama_acara' => 'required|string|max:255',
            'pic_kru' => 'required|string|max:255',
            'tanggal_booking' => 'required|date',
            'sesi_jam' => 'required|string|max:100',
        ]);

        StudioBooking::create([
            'nama_studio' => $request->nama_studio,
            'nama_acara' => $request->nama_acara,
            'pic_kru' => $request->pic_kru,
            'tanggal_booking' => $request->tanggal_booking,
            'sesi_jam' => $request->sesi_jam,
            'status' => 'dikonfirmasi',
            'admin_pembuat_id' => Auth::id(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal studio berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, StudioBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:selesai,dibatalkan',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->route('jadwal.index')->with('success', 'Status jadwal studio diperbarui.');
    }
}