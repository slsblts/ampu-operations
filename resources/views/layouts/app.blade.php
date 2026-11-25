<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMPU OPERATIONS — Ampu Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #0F172A; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between pb-20">

    <!-- Top Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
        <div class="max-w-xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                @php
                    $logoFiles = glob(public_path('images/*.*'));
                    $logoUrl = count($logoFiles) > 0 ? asset('images/' . basename($logoFiles[0])) : '';
                @endphp
                <img src="{{ $logoUrl }}" alt="Logo Ampu Studio" class="w-8 h-8 object-contain">
                <div>
                    <h1 class="text-sm font-bold tracking-tight text-slate-900 leading-none">AMPU OPERATIONS</h1>
                    <p class="text-[11px] text-slate-500 mt-0.5">Logbook Alat & Studio</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-[11px] font-medium text-slate-500 hidden sm:inline">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-medium text-rose-600 hover:text-rose-700 border border-gray-200 px-2.5 py-1 rounded">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-xl w-full mx-auto px-4 pt-4 flex-1">
        @if(session('success'))
            <div class="mb-4 p-3 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded-md bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-20">
        <div class="max-w-xl mx-auto grid grid-cols-4 h-14">
            <a href="{{ route('logbook.index') }}"
               class="flex flex-col items-center justify-center text-[11px] font-medium {{ request()->routeIs('logbook.*') ? 'text-[#1E3A8A] font-semibold' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Logbook
            </a>

            <a href="{{ route('jadwal.index') }}"
               class="flex flex-col items-center justify-center text-[11px] font-medium {{ request()->routeIs('jadwal.*') ? 'text-[#1E3A8A] font-semibold' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal
            </a>

            <a href="{{ route('inventori.index') }}"
               class="flex flex-col items-center justify-center text-[11px] font-medium {{ request()->routeIs('inventori.*') ? 'text-[#1E3A8A] font-semibold' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Inventori
            </a>

            <a href="{{ route('riwayat.index') }}"
               class="flex flex-col items-center justify-center text-[11px] font-medium {{ request()->routeIs('riwayat.*') ? 'text-[#1E3A8A] font-semibold' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat
            </a>
        </div>
    </nav>
    @stack('scripts')
</body>
</html>