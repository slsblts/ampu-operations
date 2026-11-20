@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3">
        <div class="flex items-center gap-1.5 font-medium text-slate-700">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            JADWAL STUDIO • STUDIO 1 & 2
        </div>
        <span>{{ now()->format('d M Y') }}</span>
    </div>

    <!-- Form Booking Studio -->
    <section class="bg-white border border-gray-200 rounded-md p-4 mb-5">
        <div class="mb-3">
            <h2 class="text-base font-bold text-slate-900">Booking Studio Baru</h2>
            <p class="text-[11px] text-slate-500">Form Reservasi Ruang Studio Ampu</p>
        </div>

        <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Pilih Studio</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="studio_name" value="Studio 1 - Podcast" checked class="peer hidden">
                        <div class="text-center py-2 px-3 text-xs font-medium border border-gray-300 rounded-md peer-checked:bg-[#1E3A8A] peer-checked:text-white peer-checked:border-[#1E3A8A]">
                            Studio 1 - Podcast
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="studio_name" value="Studio 2 - Utama" class="peer hidden">
                        <div class="text-center py-2 px-3 text-xs font-medium border border-gray-300 rounded-md peer-checked:bg-[#1E3A8A] peer-checked:text-white peer-checked:border-[#1E3A8A]">
                            Studio 2 - Utama
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Nama Project / Acara</label>
                <input type="text" name="project_name" placeholder="Contoh: Tiki Talks Ep. 15" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">PIC / Kru Bertugas</label>
                <input type="text" name="pic_crew" placeholder="Contoh: Nizar, Ratim, Abi" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="booking_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Rentang Jam</label>
                    <input type="text" name="time_slot" placeholder="13:00 - 16:00 WIB" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#1E3A8A] hover:bg-blue-900 text-white text-sm font-medium py-2.5 rounded-md transition">
                + Simpan Jadwal Studio
            </button>
        </form>
    </section>

    <!-- Daftar Jadwal Terdekat -->
    <section class="bg-white border border-gray-200 rounded-md p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-slate-900">Jadwal Terdekat</h2>
            <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                {{ $bookings->count() }} Sesi Terjadwal
            </span>
        </div>

        <div class="space-y-3">
            @forelse($bookings as $booking)
                <div class="border border-gray-200 rounded-md p-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-[#1E3A8A]">
                            {{ $booking->studio_name }}
                        </span>
                        <span class="text-[11px] text-slate-500">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </span>
                    </div>

                    <h3 class="text-sm font-semibold text-slate-900">{{ $booking->project_name }}</h3>
                    <p class="text-xs text-slate-600 mt-1">
                        Jam: <strong>{{ $booking->time_slot }}</strong> • PIC: {{ $booking->pic_crew }}
                    </p>

                    <div class="flex justify-end gap-2 mt-2.5 pt-2 border-t border-gray-100">
                        <form action="{{ route('jadwal.status', $booking->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="text-[11px] font-medium text-emerald-700 hover:underline px-2 py-0.5">
                                Selesai
                            </button>
                        </form>
                        <form action="{{ route('jadwal.status', $booking->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="text-[11px] font-medium text-rose-600 hover:underline px-2 py-0.5">
                                Batal
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-500 text-center py-6">Belum ada jadwal studio mendatang.</p>
            @endforelse
        </div>
    </section>
@endsection