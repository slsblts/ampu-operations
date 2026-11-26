@extends('layouts.app')

@section('content')
<div class="space-y-5 pb-24">
    {{-- Header Section --}}
    <div class="flex items-center justify-between gap-2">
        <div>
            <p class="text-[11px] font-bold tracking-wider text-indigo-600 uppercase">REKAP ASET STUDIO</p>
            <h1 class="text-lg font-extrabold text-slate-900">Inventori Alat Ampu Studio</h1>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('inventori.export') }}"
                class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                <span>↓ CSV</span>
            </a>
            <button type="button" onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="inline-flex items-center gap-1.5 rounded-xl bg-[#1E3A8A] px-3.5 py-2 text-xs font-bold text-white shadow-sm hover:bg-blue-900">
                <span>+ Tambah Alat</span>
            </button>
        </div>
    </div>

    {{-- Ringkasan Stok --}}
    <div class="grid grid-cols-3 gap-2.5">
        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <p class="text-[11px] font-medium text-slate-500">Total Unit</p>
            <p class="mt-1 text-lg font-extrabold text-slate-900">{{ $totalUnit }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/70 p-3 shadow-sm">
            <p class="text-[11px] font-medium text-emerald-700">Tersedia</p>
            <p class="mt-1 text-lg font-extrabold text-emerald-700">{{ $totalTersedia }}</p>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/70 p-3 shadow-sm">
            <p class="text-[11px] font-medium text-amber-700">Dipinjam</p>
            <p class="mt-1 text-lg font-extrabold text-amber-700">{{ $totalDipinjam }}</p>
        </div>
    </div>

    {{-- Pencarian & Filter Kategori --}}
    <form method="GET" action="{{ route('inventori.index') }}" class="space-y-2.5">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama alat, kategori, atau catatan..."
            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:outline-none">

        <div class="flex gap-1.5 overflow-x-auto pb-1">
            @foreach(['Semua', 'Kamera', 'Lensa', 'Audio', 'Lighting', 'Kabel/Aksesori'] as $kat)
                <button type="submit" name="kategori" value="{{ $kat }}"
                    class="shrink-0 rounded-full px-3 py-1 text-[11px] font-semibold transition
                    {{ (request('kategori', 'Semua') === $kat) ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                    {{ $kat }}
                </button>
            @endforeach
        </div>
    </form>

    {{-- Daftar Inventori --}}
    <div class="space-y-3">
        @forelse($inventories as $item)
            @php $lagiDipinjam = $item->sedangDipinjam(); @endphp
            <div class="rounded-2xl border border-slate-200 bg-white p-3.5 shadow-sm">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            @if($item->kategori)
                                <span class="rounded-md bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600 uppercase">
                                    {{ $item->kategori }}
                                </span>
                            @endif
                            <span class="rounded-md px-2 py-0.5 text-[10px] font-bold
                                {{ $item->kondisi === 'Baik' ? 'bg-emerald-50 text-emerald-700' : ($item->kondisi === 'Perlu Servis' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">
                                {{ $item->kondisi }}
                            </span>
                        </div>
                        <h3 class="mt-1.5 text-sm font-bold text-slate-900">{{ $item->nama_alat }}</h3>
                        @if($item->catatan)
                            <p class="mt-0.5 text-[11px] text-slate-500">{{ $item->catatan }}</p>
                        @endif
                    </div>

                    <div class="text-right shrink-0">
                        <span class="inline-block rounded-lg px-2.5 py-1 text-xs font-extrabold
                            {{ $item->stok_tersedia > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ $item->stok_tersedia }} / {{ $item->stok_total }} Ready
                        </span>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-end gap-2 border-t border-slate-100 pt-2.5">
                    <button type="button"
                        onclick="openEditModal({{ $item->id }}, @js($item->nama_alat), @js($item->kategori), {{ $item->stok_total }}, {{ $item->stok_tersedia }}, @js($item->kondisi), @js($item->catatan))"
                        class="rounded-lg border border-slate-200 px-2.5 py-1 text-[11px] font-semibold text-slate-700 hover:bg-slate-50">
                        Edit
                    </button>

                    @if($lagiDipinjam)
                        <button type="button" disabled
                            title="Alat sedang dipinjam dan tidak dapat dihapus"
                            class="cursor-not-allowed rounded-lg border border-slate-200 bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-400">
                            Sedang Dipinjam
                        </button>
                    @else
                        <form action="{{ route('inventori.destroy', $item) }}" method="POST"
                            onsubmit="return confirm('Hapus {{ $item->nama_alat }} dari daftar inventori?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-lg border border-rose-200 bg-rose-50/60 px-2.5 py-1 text-[11px] font-semibold text-rose-600 hover:bg-rose-100">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
                <p class="text-xs font-semibold text-slate-600">Belum ada data alat di inventori.</p>
                <p class="mt-1 text-[11px] text-slate-400">Klik tombol "+ Tambah Alat" di atas untuk mulai mendata peralatan Ampu Studio.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Alat --}}
<div id="modalTambah" class="fixed inset-0 z-50 hidden flex items-end sm:items-center justify-center bg-slate-900/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-5 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="text-sm font-extrabold text-slate-900">Tambah Alat Inventori</h2>
            <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form action="{{ route('inventori.store') }}" method="POST" class="mt-4 space-y-3">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-700">Nama Alat *</label>
                <input type="text" name="nama_alat" required placeholder="Contoh: Sony A7 III / Tripod Takara"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Kategori</label>
                    <select name="kategori" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                        <option value="Kamera">Kamera</option>
                        <option value="Lensa">Lensa</option>
                        <option value="Audio">Audio</option>
                        <option value="Lighting">Lighting</option>
                        <option value="Kabel/Aksesori">Kabel/Aksesori</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Jumlah Unit *</label>
                    <input type="number" name="stok_total" value="1" min="1" required
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700">Kondisi</label>
                <select name="kondisi" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                    <option value="Baik">Baik</option>
                    <option value="Perlu Servis">Perlu Servis</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700">Catatan / Kelengkapan (Opsional)</label>
                <input type="text" name="catatan" placeholder="Contoh: Termasuk 2 baterai + tas kamera"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600">Batal</button>
                <button type="submit"
                    class="rounded-xl bg-[#1E3A8A] px-4 py-2 text-xs font-bold text-white hover:bg-blue-900">Simpan Alat</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Alat --}}
<div id="modalEdit" class="fixed inset-0 z-50 hidden flex items-end sm:items-center justify-center bg-slate-900/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-5 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="text-sm font-extrabold text-slate-900">Edit Data Inventori</h2>
            <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="formEdit" method="POST" class="mt-4 space-y-3">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[11px] font-bold text-slate-700">Nama Alat *</label>
                <input type="text" id="edit_nama_alat" name="nama_alat" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Kategori</label>
                    <select id="edit_kategori" name="kategori" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                        <option value="Kamera">Kamera</option>
                        <option value="Lensa">Lensa</option>
                        <option value="Audio">Audio</option>
                        <option value="Lighting">Lighting</option>
                        <option value="Kabel/Aksesori">Kabel/Aksesori</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Kondisi</label>
                    <select id="edit_kondisi" name="kondisi" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                        <option value="Baik">Baik</option>
                        <option value="Perlu Servis">Perlu Servis</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Stok Total *</label>
                    <input type="number" id="edit_stok_total" name="stok_total" min="1" required
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700">Stok Tersedia *</label>
                    <input type="number" id="edit_stok_tersedia" name="stok_tersedia" min="0" required
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700">Catatan / Kelengkapan</label>
                <input type="text" id="edit_catatan" name="catatan"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600">Batal</button>
                <button type="submit"
                    class="rounded-xl bg-[#1E3A8A] px-4 py-2 text-xs font-bold text-white hover:bg-blue-900">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, kategori, total, tersedia, kondisi, catatan) {
        document.getElementById('formEdit').action = '/inventori/' + id;
        document.getElementById('edit_nama_alat').value = nama;
        document.getElementById('edit_kategori').value = kategori || 'Kamera';
        document.getElementById('edit_stok_total').value = total;
        document.getElementById('edit_stok_tersedia').value = tersedia;
        document.getElementById('edit_kondisi').value = kondisi || 'Baik';
        document.getElementById('edit_catatan').value = catatan || '';
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endsection