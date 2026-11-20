@extends('layouts.app')

@section('content')
    <!-- Status Bar -->
    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3">
        <div class="flex items-center gap-1.5 font-medium text-slate-700">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            LOGBOOK AKTIF • STUDIO 1 & 2
        </div>
        <span>Ampu Studio Lt. 3</span>
    </div>

    <!-- Form Catat Peminjaman -->
    <section class="bg-white border border-gray-200 rounded-md p-4 mb-5">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-slate-900">Catat Peminjaman</h2>
            <span class="text-[11px] text-slate-400">Form Cepat Alat Studio</span>
        </div>

        <form action="{{ route('logbook.store') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Nama Peminjam</label>
                <input type="text" name="borrower_name" placeholder="Contoh: Priya / Rizki" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">NIM / NIK</label>
                    <input type="text" name="borrower_id_number" placeholder="Contoh: 25SA21A4" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="phone_number" placeholder="Contoh: 081930522954" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Organisasi / Divisi</label>
                    <input type="text" name="organization" placeholder="Contoh: HMPSSI / Intermedia" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Keperluan / Acara</label>
                    <input type="text" name="purpose" placeholder="Contoh: Podcast / Makrab IF" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <!-- Daftar Barang & Jumlah -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Daftar Barang & Jumlah</label>
                <div id="items-container" class="space-y-2">
                    <div class="grid grid-cols-12 gap-2">
                        <input type="text" name="items[0][name]" placeholder="Nama alat (misal: Tripod Kamera)" required
                               class="col-span-9 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                        <input type="number" name="items[0][qty]" value="1" min="1" required
                               class="col-span-3 px-2.5 py-2 text-sm text-center border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                    </div>
                </div>
                <button type="button" onclick="addItemRow()"
                        class="mt-2 text-xs font-medium text-[#1E3A8A] hover:underline">
                    + Tambah Baris Alat
                </button>
            </div>

            <!-- Auto Admin Mengetahui -->
            <div class="flex items-center justify-between px-3 py-2 rounded bg-slate-50 border border-gray-200 text-xs">
                <span class="text-slate-600">Mengetahui: <strong class="text-slate-900">{{ Auth::user()->name }}</strong></span>
                <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 font-medium">Auto-assigned</span>
            </div>

            <button type="submit"
                    class="w-full bg-[#1E3A8A] hover:bg-blue-900 text-white text-sm font-medium py-2.5 rounded-md transition">
                Catat Peminjaman
            </button>
        </form>
    </section>

    <!-- Daftar Sedang Dipinjam -->
    <section class="bg-white border border-gray-200 rounded-md p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-slate-900">Sedang Dipinjam</h2>
            <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200">
                {{ $activeLoans->count() }} Peminjaman Aktif
            </span>
        </div>

        <div class="space-y-3">
            @forelse($activeLoans as $loan)
                @php
                    $itemsSummary = $loan->items->map(fn($i) => "{$i->item_name} ({$i->quantity})")->implode(', ');
                @endphp
                <div class="border border-gray-200 rounded-md p-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $loan->borrower_name }}
                                <span class="text-xs font-normal text-slate-500">({{ $loan->borrower_id_number }})</span>
                            </h3>
                            <p class="text-xs font-medium text-[#1E3A8A] mt-0.5">
                                {{ $loan->organization }} • {{ $loan->purpose }}
                            </p>
                        </div>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($loan->borrow_date)->format('d M Y') }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-700 mt-2 leading-relaxed bg-slate-50 p-2 rounded border border-gray-100">
                        {{ $itemsSummary }}
                    </p>

                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">HP: {{ $loan->phone_number }}</span>
                        <button type="button"
                                onclick="openReturnModal({{ $loan->id }}, '{{ addslashes($loan->borrower_name) }} ({{ $loan->borrower_id_number }})', '{{ $loan->phone_number }}', '{{ addslashes($loan->organization . ' • ' . $loan->purpose) }}', '{{ addslashes($itemsSummary) }}')"
                                class="text-xs font-medium text-slate-800 bg-white hover:bg-slate-50 border border-gray-300 px-3 py-1.5 rounded-md">
                            Kembalikan
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-500 text-center py-6">Tidak ada alat yang sedang dipinjam saat ini.</p>
            @endforelse
        </div>
    </section>

    <!-- Modal Konfirmasi Pengembalian Alat -->
    <div id="returnModal" class="fixed inset-0 bg-slate-900/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white border border-gray-200 rounded-md w-full max-w-md p-5">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3 mb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Konfirmasi Pengembalian Alat</h3>
                    <p class="text-[11px] text-slate-500">Verifikasi kondisi & kelengkapan sebelum disimpan ke rak</p>
                </div>
                <button type="button" onclick="closeReturnModal()" class="text-slate-400 hover:text-slate-700 text-lg leading-none">&times;</button>
            </div>

            <div class="bg-slate-50 border border-gray-200 rounded p-3 text-xs space-y-1.5 mb-4">
                <div class="flex justify-between"><span class="text-slate-500">Peminjam</span><strong id="modalBorrower" class="text-slate-900"></strong></div>
                <div class="flex justify-between"><span class="text-slate-500">No. HP</span><span id="modalPhone" class="text-slate-800"></span></div>
                <div class="flex justify-between"><span class="text-slate-500">Organisasi & Acara</span><span id="modalPurpose" class="text-slate-800"></span></div>
                <div class="pt-1 border-t border-gray-200">
                    <span class="text-slate-500 block mb-1">Daftar Barang & Jumlah:</span>
                    <p id="modalItems" class="font-medium text-slate-900"></p>
                </div>
            </div>

            <form id="returnForm" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Status Kondisi Fisik</label>
                    <select name="return_condition" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                        <option value="Lengkap & Normal">Lengkap & Normal</option>
                        <option value="Perlu Cek">Perlu Cek</option>
                        <option value="Kurang/Rusak">Kurang / Rusak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Catatan Kondisi Alat (Opsional)</label>
                    <input type="text" name="return_notes" placeholder="Contoh: Lengkap, baterai penuh, aman"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>

                <div class="flex items-center justify-between px-3 py-2 rounded bg-slate-50 border border-gray-200 text-xs">
                    <span class="text-slate-600">Diterima oleh: <strong class="text-slate-900">{{ Auth::user()->name }}</strong></span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-medium">Verified</span>
                </div>

                <div class="grid grid-cols-2 gap-2.5 pt-2">
                    <button type="button" onclick="closeReturnModal()"
                            class="w-full py-2 text-xs font-medium text-slate-700 bg-white border border-gray-300 rounded-md hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="w-full py-2 text-xs font-medium text-white bg-[#1E3A8A] hover:bg-blue-900 rounded-md">
                        Tandai Sudah Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let itemIndex = 1;
    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-12 gap-2';
        row.innerHTML = `
            <input type="text" name="items[${itemIndex}][name]" placeholder="Nama alat berikutnya..." required
                   class="col-span-9 px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            <input type="number" name="items[${itemIndex}][qty]" value="1" min="1" required
                   class="col-span-3 px-2.5 py-2 text-sm text-center border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
        `;
        container.appendChild(row);
        itemIndex++;
    }

    function openReturnModal(loanId, borrower, phone, purpose, items) {
        document.getElementById('modalBorrower').textContent = borrower;
        document.getElementById('modalPhone').textContent = phone;
        document.getElementById('modalPurpose').textContent = purpose;
        document.getElementById('modalItems').textContent = items;
        document.getElementById('returnForm').action = `/logbook/${loanId}/return`;

        const modal = document.getElementById('returnModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReturnModal() {
        const modal = document.getElementById('returnModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush