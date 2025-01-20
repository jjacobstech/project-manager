<html>

<head>
    <title>Taskon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('app_logo.png') }}" type="image/x-icon">
    <script src="{{ asset('assets/pspdfkit.js') }}"></script>
</head>

<body class="items-center justify-center w-screen min-h-screen bg-teal-900">
    <header class="grid items-center w-full grid-cols-2 text-black bg-white h-14 lg:grid-cols-3">

        @if (Route::has('login'))
            <nav class="flex justify-end flex-1 w-screen -mx-3 space">
                @auth

                    <a href="{{ url('/dashboard') }}" class="rounded ">
                        <x-nav-button>
                            {{ __('Dashboard') }}
                        </x-nav-button>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-2 py-4 rounded">
                        <x-nav-button>
                            {{ __('Log in') }}
                        </x-nav-button>
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-2 py-4 rounded">
                            <x-nav-button>
                                {{ __('Register') }}
                            </x-nav-button>
                        </a>
                    @endif
                @endauth
            </nav>


        @endif
    </header>
    <div class="text-center text-white mt-28">
        <div class="inline-block p-6 bg-white rounded-full ">
            <img class="w-10" src="{{ asset('app_logo.png') }}" alt="logo" srcset="">
        </div>

        <h1 class="mt-6 text-4xl font-bold">TASKON</h1>
        <div class="flex items-center justify-center mt-2">
            <div class="w-16 border-t border-white"></div>
            <p class="mx-4 text-lg">The Enterprise<br>Task Management<br>System</p>
            <div class="w-16 border-t border-white"></div>
        </div>
    </div>
    {{-- <div id="pspdfkit" style="width: 100%; height: 100vh; " class="bg-black"></div> --}}
    {{-- <script src="{{ asset('index.js') }}"></script> --}}

</body>
<script src="{{ asset('build/assets/style.js') }}"></script>

</html>
