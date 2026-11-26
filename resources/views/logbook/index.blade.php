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
            <span class="text-[11px] text-slate-400">Terhubung Inventori</span>
        </div>

        <form action="{{ route('logbook.store') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}" placeholder="Contoh: Priya / Rizki" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">NIM / NIK</label>
                    <input type="text" name="nim_nik" value="{{ old('nim_nik') }}" placeholder="Contoh: 25SA21A4" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081930522954" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Organisasi / Divisi</label>
                    <input type="text" name="organisasi" value="{{ old('organisasi') }}" placeholder="Contoh: HMPSSI / Intermedia" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Keperluan / Acara</label>
                    <input type="text" name="keperluan" value="{{ old('keperluan') }}" placeholder="Contoh: Podcast / Makrab IF" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
            </div>

            <!-- Daftar Barang & Jumlah -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-medium text-slate-700">Daftar Barang & Jumlah</label>
                    <span class="text-[10px] text-slate-400">Klik untuk pilih atau ketik manual</span>
                </div>

                <div id="items-container" class="space-y-2">
                    <div class="grid grid-cols-12 gap-2 item-row">
                        <div class="col-span-9 relative dropdown-wrapper">
                            <input type="hidden" name="items[0][inventory_id]" class="inventory-id-input">
                            <input type="text" name="items[0][name]"
                                   onfocus="openItemDropdown(this)"
                                   oninput="filterItemDropdown(this)"
                                   placeholder="Pilih / ketik nama alat..." required autocomplete="off"
                                   class="item-name-input w-full pl-3 pr-8 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                            <button type="button" onclick="toggleItemDropdown(this)"
                                    class="absolute inset-y-0 right-0 px-2.5 flex items-center text-slate-500 hover:text-slate-800"
                                    tabindex="-1" title="Lihat daftar alat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="item-dropdown hidden absolute left-0 right-0 mt-1 max-h-52 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg z-30 divide-y divide-gray-100"></div>
                        </div>

                        <input type="number" name="items[0][qty]" value="1" min="1" required
                               class="col-span-3 px-2.5 py-2 text-sm text-center border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A] qty-input">
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
                    $itemsSummary = $loan->items->map(fn($i) => "{$i->nama_barang} ({$i->jumlah})")->implode(', ');
                @endphp
                <div class="border border-gray-200 rounded-md p-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $loan->nama_peminjam }}
                                <span class="text-xs font-normal text-slate-500">({{ $loan->nim_nik }})</span>
                            </h3>
                            <p class="text-xs font-medium text-[#1E3A8A] mt-0.5">
                                {{ $loan->organisasi }} • {{ $loan->keperluan }}
                            </p>
                        </div>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-700 mt-2 leading-relaxed bg-slate-50 p-2 rounded border border-gray-100">
                        {{ $itemsSummary }}
                    </p>

                    <div class="mt-2.5 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">HP: {{ $loan->no_hp }}</span>
                        <button type="button"
                                onclick="openReturnModal({{ $loan->id }}, '{{ addslashes($loan->nama_peminjam) }} ({{ $loan->nim_nik }})', '{{ $loan->no_hp }}', '{{ addslashes($loan->organisasi . ' • ' . $loan->keperluan) }}', '{{ addslashes($itemsSummary) }}')"
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
                    <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Status Kondisi Fisik</label>
                    <select name="kondisi_kembali" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                        <option value="Lengkap & Normal">Lengkap & Normal</option>
                        <option value="Perlu Cek">Perlu Cek</option>
                        <option value="Kurang/Rusak">Kurang / Rusak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Catatan Kondisi Alat (Opsional)</label>
                    <input type="text" name="catatan_kembali" placeholder="Contoh: Lengkap, baterai penuh, aman"
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
@php
    $formattedInventories = $inventories->map(function ($item) {
        return [
            'id' => $item->id,
            'nama' => $item->nama_alat,
            'kategori' => $item->kategori ?? '',
            'stok' => $item->stok_tersedia,
        ];
    })->values();
@endphp
<script>
    const inventoryList = {!! json_encode($formattedInventories) !!};

    function closeAllDropdowns() {
        document.querySelectorAll('.item-dropdown').forEach(el => el.classList.add('hidden'));
    }

    function renderDropdownOptions(wrapper, keyword = '') {
        const dropdown = wrapper.querySelector('.item-dropdown');
        const q = keyword.trim().toLowerCase();

        const filtered = inventoryList.filter(item =>
            item.nama.toLowerCase().includes(q) || item.kategori.toLowerCase().includes(q)
        );

        if (filtered.length === 0) {
            dropdown.innerHTML = `
                <div class="px-3 py-2.5 text-xs text-slate-500">
                    Tidak ada di master inventori — lanjut ketik untuk input manual.
                </div>`;
            return;
        }

        dropdown.innerHTML = filtered.map(item => `
            <button type="button"
                    onclick="selectInventoryItem(this, ${item.id}, ${JSON.stringify(item.nama).replace(/"/g, '&quot;')}, ${item.stok})"
                    class="w-full text-left px-3 py-2 hover:bg-slate-50 flex items-center justify-between gap-2 transition">
                <span class="text-xs font-medium text-slate-800 truncate">${item.nama}</span>
                <span class="shrink-0 text-[10px] font-semibold px-1.5 py-0.5 rounded bg-indigo-50 text-[#1E3A8A]">
                    Ready: ${item.stok}
                </span>
            </button>
        `).join('');
    }

    function openItemDropdown(inputEl) {
        closeAllDropdowns();
        const wrapper = inputEl.closest('.dropdown-wrapper');
        renderDropdownOptions(wrapper, inputEl.value);
        wrapper.querySelector('.item-dropdown').classList.remove('hidden');
    }

    function toggleItemDropdown(btnEl) {
        const wrapper = btnEl.closest('.dropdown-wrapper');
        const dropdown = wrapper.querySelector('.item-dropdown');
        const inputEl = wrapper.querySelector('.item-name-input');
        const isHidden = dropdown.classList.contains('hidden');

        closeAllDropdowns();
        if (isHidden) {
            renderDropdownOptions(wrapper, '');
            dropdown.classList.remove('hidden');
            inputEl.focus();
        }
    }

    function filterItemDropdown(inputEl) {
        const wrapper = inputEl.closest('.dropdown-wrapper');
        const row = inputEl.closest('.item-row');
        const hiddenId = row.querySelector('.inventory-id-input');
        const qtyInput = row.querySelector('.qty-input');

        const exactMatch = inventoryList.find(item => item.nama.toLowerCase() === inputEl.value.trim().toLowerCase());
        if (exactMatch) {
            hiddenId.value = exactMatch.id;
            qtyInput.max = exactMatch.stok;
            if (parseInt(qtyInput.value || 1) > exactMatch.stok) qtyInput.value = exactMatch.stok;
        } else {
            hiddenId.value = '';
            qtyInput.removeAttribute('max');
        }

        renderDropdownOptions(wrapper, inputEl.value);
        wrapper.querySelector('.item-dropdown').classList.remove('hidden');
    }

    function selectInventoryItem(optionBtn, id, nama, stok) {
        const row = optionBtn.closest('.item-row');
        const nameInput = row.querySelector('.item-name-input');
        const hiddenId = row.querySelector('.inventory-id-input');
        const qtyInput = row.querySelector('.qty-input');

        nameInput.value = nama;
        hiddenId.value = id;
        qtyInput.max = stok;
        if (parseInt(qtyInput.value || 1) > stok) qtyInput.value = stok;

        closeAllDropdowns();
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown-wrapper')) {
            closeAllDropdowns();
        }
    });

    let itemIndex = 1;
    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-12 gap-2 item-row';
        row.innerHTML = `
            <div class="col-span-8 relative dropdown-wrapper">
                <input type="hidden" name="items[${itemIndex}][inventory_id]" class="inventory-id-input">
                <input type="text" name="items[${itemIndex}][name]"
                       onfocus="openItemDropdown(this)"
                       oninput="filterItemDropdown(this)"
                       placeholder="Pilih / ketik alat berikutnya..." required autocomplete="off"
                       class="item-name-input w-full pl-3 pr-8 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                <button type="button" onclick="toggleItemDropdown(this)"
                        class="absolute inset-y-0 right-0 px-2.5 flex items-center text-slate-500 hover:text-slate-800"
                        tabindex="-1" title="Lihat daftar alat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="item-dropdown hidden absolute left-0 right-0 mt-1 max-h-52 overflow-y-auto bg-white border border-gray-200 rounded-md shadow-lg z-30 divide-y divide-gray-100"></div>
            </div>
            <input type="number" name="items[${itemIndex}][qty]" value="1" min="1" required
                   class="col-span-3 px-2.5 py-2 text-sm text-center border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A] qty-input">
            <button type="button" onclick="this.closest('.item-row').remove()"
                    class="col-span-1 flex items-center justify-center text-slate-400 hover:text-rose-600 text-base font-bold"
                    title="Hapus baris">&times;</button>
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