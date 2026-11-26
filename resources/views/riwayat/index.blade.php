@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3">
        <div class="flex items-center gap-1.5 font-medium text-slate-700">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            {{ $tab === 'studio' ? 'ARSIP PEMINJAMAN STUDIO' : 'ARSIP PENGEMBALIAN ALAT' }}
        </div>
        <a href="{{ route('riwayat.export', ['tab' => $tab]) }}" class="font-semibold text-[#1E3A8A] hover:underline">
            ↓ Export CSV
        </a>
    </div>

    <!-- Tab Switcher: Alat vs Studio -->
    <div class="grid grid-cols-2 gap-2 mb-3 bg-white p-1 border border-gray-200 rounded-md">
        <a href="{{ route('riwayat.index', ['tab' => 'alat', 'filter' => request('filter')]) }}"
           class="text-center py-1.5 text-xs font-semibold rounded transition {{ $tab === 'alat' ? 'bg-[#1E3A8A] text-white' : 'text-slate-600 hover:bg-slate-50' }}">
            Riwayat Alat ({{ $returnedLoans->count() }})
        </a>
        <a href="{{ route('riwayat.index', ['tab' => 'studio', 'filter' => request('filter')]) }}"
           class="text-center py-1.5 text-xs font-semibold rounded transition {{ $tab === 'studio' ? 'bg-[#1E3A8A] text-white' : 'text-slate-600 hover:bg-slate-50' }}">
            Riwayat Studio ({{ $completedBookings->count() }})
        </a>
    </div>

    <!-- Search & Filter -->
    <section class="bg-white border border-gray-200 rounded-md p-3 mb-4">
        <form action="{{ route('riwayat.index') }}" method="GET" class="space-y-2.5">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ $tab === 'studio' ? 'Cari studio, nama proyek, atau PIC kru...' : 'Cari nama peminjam, NIM, organisasi, atau alat...' }}"
                   class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">

            <div class="flex items-center gap-1.5 text-xs">
                <a href="{{ route('riwayat.index', ['tab' => $tab]) }}"
                   class="px-3 py-1 rounded {{ !request('filter') ? 'bg-[#1E3A8A] text-white font-medium' : 'bg-slate-100 text-slate-600' }}">
                    Semua
                </a>
                <a href="{{ route('riwayat.index', ['tab' => $tab, 'filter' => 'today']) }}"
                   class="px-3 py-1 rounded {{ request('filter') === 'today' ? 'bg-[#1E3A8A] text-white font-medium' : 'bg-slate-100 text-slate-600' }}">
                    Hari Ini
                </a>
                <a href="{{ route('riwayat.index', ['tab' => $tab, 'filter' => 'week']) }}"
                   class="px-3 py-1 rounded {{ request('filter') === 'week' ? 'bg-[#1E3A8A] text-white font-medium' : 'bg-slate-100 text-slate-600' }}">
                    Minggu Ini
                </a>
            </div>
        </form>
    </section>

    @if($tab === 'studio')
        <!-- Daftar Riwayat Studio -->
        <section class="bg-white border border-gray-200 rounded-md p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-slate-900">Riwayat Pemakaian Studio</h2>
                <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                    Total {{ $completedBookings->count() }} Jadwal
                </span>
            </div>

            <div class="space-y-3">
                @forelse($completedBookings as $booking)
                    <div class="border border-gray-200 rounded-md p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#1E3A8A]">
                                    {{ $booking->nama_studio }}
                                </span>
                                <h3 class="text-sm font-semibold text-slate-900 mt-0.5">
                                    {{ $booking->nama_acara }}
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    PIC / Kru: <strong class="text-slate-700">{{ $booking->pic_kru }}</strong> • Sesi: {{ $booking->sesi_jam }}
                                </p>
                            </div>
                            @if($booking->status === 'selesai')
                                <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Selesai
                                </span>
                            @else
                                <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200">
                                    Dibatalkan
                                </span>
                            @endif
                        </div>

                        <div class="mt-2.5 pt-2 border-t border-gray-100 flex flex-wrap items-center justify-between gap-1 text-[11px] text-slate-500">
                            <span>Tanggal: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</strong></span>
                            <span>Dicatat oleh: <strong>{{ $booking->createdBy->name ?? '-' }}</strong></span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada arsip pemakaian studio.</p>
                @endforelse
            </div>
        </section>
    @else
        <!-- Daftar Riwayat Alat -->
        <section class="bg-white border border-gray-200 rounded-md p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-slate-900">Riwayat Peminjaman Alat</h2>
                <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                    Total {{ $returnedLoans->count() }} Transaksi
                </span>
            </div>

            <div class="space-y-3">
                @forelse($returnedLoans as $loan)
                    <div class="border border-gray-200 rounded-md p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">
                                    {{ $loan->nama_peminjam }}
                                    <span class="text-xs font-normal text-slate-500">({{ $loan->nim_nik }})</span>
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    HP: {{ $loan->no_hp }} • {{ $loan->organisasi }} — {{ $loan->keperluan }}
                                </p>
                            </div>
                            <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Dikembalikan
                            </span>
                        </div>

                        <div class="mt-2 bg-slate-50 border border-gray-100 rounded p-2 text-xs text-slate-800">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block mb-0.5">Barang Dipinjam:</span>
                            {{ $loan->items->map(fn($i) => "{$i->nama_barang} ({$i->jumlah})")->implode(', ') }}
                        </div>

                        <div class="mt-2.5 pt-2 border-t border-gray-100 flex flex-wrap items-center justify-between gap-1 text-[11px] text-slate-500">
                            <span>
                                {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} →
                                <strong class="text-slate-700">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</strong>
                            </span>
                            <span>Mengetahui: <strong>{{ $loan->receivedBy->name ?? ($loan->issuedBy->name ?? '-') }}</strong></span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada arsip pengembalian alat.</p>
                @endforelse
            </div>
        </section>
    @endif
@endsection