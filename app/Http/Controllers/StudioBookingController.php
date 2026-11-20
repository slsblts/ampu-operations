<?php

namespace App\Http\Controllers;

use App\Models\StudioBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioBookingController extends Controller
{
    public function index()
    {
        $bookings = StudioBooking::whereIn('status', ['scheduled', 'confirmed'])
            ->orderBy('booking_date')
            ->get();

        return view('jadwal.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_name' => 'required|string|max:100',
            'project_name' => 'required|string|max:255',
            'pic_crew' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'time_slot' => 'required|string|max:100',
        ]);

        StudioBooking::create([
            'studio_name' => $request->studio_name,
            'project_name' => $request->project_name,
            'pic_crew' => $request->pic_crew,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'status' => 'confirmed',
            'created_by_admin_id' => Auth::id(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal studio berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, StudioBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->route('jadwal.index')->with('success', 'Status jadwal studio diperbarui.');
    }
}