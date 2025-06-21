<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ReutilizaGT</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
               body { font-family: 'Instrument Sans', sans-serif; }
               /* Minimal styles to prevent a completely unstyled page */
               .bg-\[\#FDFDFC\] { background-color: #FDFDFC; }
               .dark\:bg-\[\#0a0a0a\] { background-color: #0a0a0a; }
               .text-\[\#1b1b18\] { color: #1b1b18; }
               .dark\:text-\[\#EDEDEC\] { color: #EDEDEC; }
               .flex { display: flex; }
               .p-6 { padding: 1.5rem; }
               .lg\:p-8 { padding: 2rem; }
               .items-center { align-items: center; }
               .lg\:justify-center { justify-content: center; }
               .min-h-screen { min-height: 100vh; }
               .flex-col { flex-direction: column; }
               .w-full { width: 100%; }
               .mb-6 { margin-bottom: 1.5rem; }
               .not-has-\[nav\]\:hidden:not(:has(nav)) { display: none; }
               .inline-block { display: inline-block; }
               .px-5 { padding-left: 1.25rem; padding-right: 1.25rem; }
               .py-1\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }
               .border { border-width: 1px; border-style: solid; }
               .rounded-sm { border-radius: 0.125rem; }
               .text-sm { font-size: 0.875rem; }
               .leading-normal { line-height: 1.5; }
               .gap-4 { gap: 1rem; }
               .lg\:max-w-4xl { max-width: 56rem; } /* 896px */
               .max-w-\[335px\] { max-width: 335px; }
               .opacity-100 { opacity: 1; }
               .duration-750 { transition-duration: 750ms; }
               .lg\:grow { flex-grow: 1; }
               .starting\:opacity-0 { opacity: 0; } /* Tailwind JIT class */
               .flex-col-reverse { flex-direction: column-reverse; }
               .lg\:flex-row { flex-direction: row; }
               .text-\[14px\] { font-size: 14px; }
               .leading-\[22px\] { line-height: 22px; }
               .flex-1 { flex: 1 1 0%; }
               .p-6 { padding: 1.5rem; }
               .pb-12 { padding-bottom: 3rem; }
               .lg\:p-20 { padding: 5rem; }
               .bg-white { background-color: #fff; }
               .dark\:bg-gray-900 { background-color: #1a202c; }
               .dark\:text-gray-100 { color: #f7fafc; }
               .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
               .rounded-bl-lg { border-bottom-left-radius: 0.5rem; }
               .rounded-br-lg { border-bottom-right-radius: 0.5rem; }
               .lg\:rounded-tl-lg { border-top-left-radius: 0.5rem; }
               .lg\:rounded-br-none { border-bottom-right-radius: 0; }
               .mb-2 { margin-bottom: 0.5rem; }
               .text-2xl { font-size: 1.5rem; }
               .font-semibold { font-weight: 600; }
               .text-green-700 { color: #047857; }
               .dark\:text-green-400 { color: #4ade80; }
               .mb-4 { margin-bottom: 1rem; }
               .text-gray-700 { color: #4a5568; }
               .dark\:text-gray-300 { color: #cbd5e0; }
               .space-y-3 > :not([hidden]) ~ :not([hidden]) { margin-top: 0.75rem; }
               .w-5 { width: 1.25rem; }
               .h-5 { height: 1.25rem; }
               .text-green-600 { color: #059669; }
               .gap-3 { gap: 0.75rem; }
               .mt-6 { margin-top: 1.5rem; }
               .px-4 { padding-left: 1rem; padding-right: 1rem; }
               .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
               .bg-green-600 { background-color: #059669; }
               .text-white { color: #fff; }
               .rounded { border-radius: 0.25rem; }
               .hover\:bg-green-700:hover { background-color: #04785e; }
               .bg-green-100 { background-color: #d1fae5; }
               .dark\:bg-green-950 { background-color:rgb(75, 164, 95); }
               .rounded-t-lg { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
               .lg\:rounded-tl-none { border-top-left-radius: 0; }
               .lg\:rounded-tr-lg { border-top-right-radius: 0.5rem; }
               .max-w-xs { max-width: 20rem; }
               .p-10 { padding: 2.5rem; }
               .h-14\.5 { height: 3.625rem; }
               .hidden { display: none; }
               .lg\:block { display: block; }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-300"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition-colors duration-300"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-300">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-[14px] leading-[22px] flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-gray-900 dark:text-gray-100 shadow-md rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none" data-aos="fade-right">
                    <h1 class="mb-2 text-2xl font-semibold text-green-700 dark:text-green-400" data-aos="fade-up">Bienvenido a ReutilizaGT</h1>
                    <p class="mb-4 text-gray-700 dark:text-gray-300" data-aos="fade-up" data-aos-delay="100">
                        Comparte, reutiliza y da una segunda vida a los productos que ya no usas. Este es tu espacio para contribuir al medio ambiente.
                    </p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="200">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6" />
                            </svg>
                            <span>Publica artículos que quieras regalar</span>
                        </li>
                        <li class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="300">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18" />
                            </svg>
                            <span>Solicita artículos disponibles en tu comunidad</span>
                        </li>
                        <li class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="400">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Contribuye a un mundo más sostenible</span>
                        </li>
                    </ul>

                    <div class="mt-6" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition duration-300 ease-in-out hover:scale-105 shadow-lg">
                            Iniciar sesión
                        </a>
                    </div>
                </div>

               <div class="flex-1 flex items-center justify-center rounded-t-lg lg:rounded-tl-none lg:rounded-tr-lg p-6
                    bg-gradient-to-br from-green-50 to-green-100
                    dark:from-green-500 dark:to-green-650" 
                    data-aos="fade-left">
                        <img src="{{ asset('images/Rutiliza1.jpeg') }}" alt="ReciclaGT"
                     class="w-full max-w-xs p-10 transform transition duration-500 hover:scale-105 hover:rotate-1"
                    data-aos="zoom-in">
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>