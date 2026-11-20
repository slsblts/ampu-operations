<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — AMPU OPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #0F172A; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="bg-white border border-gray-200 rounded-md p-6">
            <div class="text-center mb-6">
                <span class="inline-block text-[10px] font-semibold tracking-wider uppercase px-2 py-0.5 rounded bg-slate-100 text-slate-600 mb-2">
                    Sistem Operasional Internal
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">AMPU OPS</h1>
                <p class="text-xs text-slate-500 mt-1">Portal Internal Logbook & Jadwal Ampu Studio</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-2.5 rounded bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@ampustudio.id') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:border-[#1E3A8A]">
                </div>

                <button type="submit"
                        class="w-full bg-[#1E3A8A] hover:bg-blue-900 text-white text-sm font-medium py-2.5 rounded-md transition">
                    Masuk ke Sistem →
                </button>
            </form>
        </div>

        <p class="text-center text-[11px] text-slate-400 mt-4">
            Akses terbatas khusus kru & admin internal Ampu Studio
        </p>
    </div>

</body>
</html>