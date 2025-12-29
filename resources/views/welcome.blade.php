<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'PainMapp') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800">

    {{-- Header --}}
    <header class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between">

            <div class="flex items-end gap-3">
                <img
                    src="{{ asset('images/logo-painmapp-visual.png') }}"
                    alt="PainMApp logo"
                    class="h-8 w-auto"
                >
                <span class="text-xl font-semibold leading-none">
                Pain<span class="text-sky-800">M</span>App
            </span>
            </div>

            <nav class="flex items-center gap-4">
                <a
                    href="{{ url('/dashboard/login') }}"
                    class="inline-flex items-center justify-center rounded-md bg-sky-800
                       px-4 py-2 text-sm font-medium text-white hover:bg-sky-600"
                >
                    Inloggen
                </a>

                <a
                    href="{{ url('/dashboard/register') }}"
                    class="text-sm font-medium text-slate-700 hover:text-slate-900 leading-none"
                >
                    Registreren
                </a>
            </nav>

        </div>
    </header>

    {{-- intro --}}
    <main class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-4xl font-bold leading-tight">
                Maak pijn
                <span class="text-sky-800">inzichtelijk</span>
            </h1>

            <p class="mt-6 text-lg text-slate-600 max-w-xl">
                PainMApp helpt cliënten en fysiotherapeuten om samen patronen te ontdekken
                bij (onverklaarbare) pijnklachten door dagelijkse registratie en heldere
                visualisaties.
            </p>

            <div class="mt-8 flex gap-4">
                <a
                    href="{{ url('/dashboard/login') }}"
                    class="inline-flex items-center rounded-md bg-sky-800 px-6 py-3
                           text-base font-medium text-white hover:bg-sky-600"
                >
                    Inloggen
                </a>

                <a
                    href="{{ url('/dashboard/register') }}"
                    class="inline-flex items-center rounded-md border border-slate-300
                           px-6 py-3 text-base font-medium text-slate-700 hover:bg-slate-100"
                >
                    Registreren
                </a>
            </div>
        </div>

        <div class="hidden md:flex items-center justify-center">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-10">
                <img
                    src="{{ asset('images/logo-painmapp.png') }}"
                    alt="PainMApp logo"
                    class="max-w-xs w-full h-auto opacity-90"
                >
            </div>
        </div>
    </main>

    {{-- Features --}}
    <section class="bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-3 gap-12">
            <div>
                <h3 class="font-semibold text-lg">Dagelijkse registratie</h3>
                <p class="mt-2 text-slate-600 text-sm">
                    Houd eenvoudig pijnscores, activiteiten, slaap en medicatie bij.
                </p>
            </div>

            <div>
                <h3 class="font-semibold text-lg">Inzicht & patronen</h3>
                <p class="mt-2 text-slate-600 text-sm">
                    Visualiseer trends en ontdek verbanden die anders verborgen blijven.
                </p>
            </div>

            <div>
                <h3 class="font-semibold text-lg">Samen met je therapeut</h3>
                <p class="mt-2 text-slate-600 text-sm">
                    Deel data veilig met je fysiotherapeut voor gerichte behandeling.
                </p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 text-center text-sm text-slate-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}
    </footer>

</body>
</html>
