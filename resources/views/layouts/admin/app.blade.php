<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel - FPI VOTE' }}</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside x-data="{ open: false }" class="bg-green-700 text-white w-64 flex flex-col fixed inset-y-0 transform transition-transform duration-300 z-30 lg:translate-x-0 shadow-xl"
               :class="{'-translate-x-full': !open}">
            <!-- Logo -->
            <div class="p-6 flex items-center justify-center border-b border-green-600 bg-green-800">
                <img src="{{ asset('images/fpi logo.png') }}" alt="FPI Logo" class="h-12 w-12 mr-3 rounded-full shadow-md object-cover">
                <span class="text-white text-2xl font-extrabold tracking-wide">FPI VOTE</span>
            </div>

            <!-- Navigation -->
<nav class="flex-1 p-4 space-y-2 overflow-y-auto">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-green-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-800' : '' }}">
        <svg class="h-5 w-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0H7v6h6v-6z" />
        </svg>
        Dashboard
    </a>
 <!-- Users -->
    <a href="{{ route('admin.users') }}" class="flex items-center p-3 rounded-lg hover:bg-green-600 transition {{ request()->routeIs('admin.users') ? 'bg-green-800' : '' }}">
        <svg class="h-5 w-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-2m-4 5h-4m0-4a4 4 0 110-8 4 4 0 010 8zM5 20h14"/>
        </svg>
        Users
    </a>


    <!-- Candidates -->
    <a href="{{ route('admin.candidates') }}" class="flex items-center p-3 rounded-lg hover:bg-green-600 transition {{ request()->routeIs('admin.candidates') ? 'bg-green-800' : '' }}">
        <svg class="h-5 w-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-2m-4 5h-4m0-4a4 4 0 110-8 4 4 0 010 8zM5 20h14"/>
        </svg>
        Candidates
    </a>
    <!-- Elections -->
    <a href="{{ route('admin.elections') }}" class="flex items-center p-3 rounded-lg hover:bg-green-600 transition {{ request()->routeIs('admin.elections') ? 'bg-green-800' : '' }}">
        <svg class="h-5 w-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13h14M5 9h14M5 5h14M9 17v-6h6v6"/>
        </svg>
        Elections
    </a>


    <!-- Results -->
    <a href="{{ route('admin.results') }}" class="flex items-center p-3 rounded-lg hover:bg-green-600 transition {{ request()->routeIs('admin.results') ? 'bg-green-800' : '' }}">
        <svg class="h-5 w-5 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V7a4 4 0 118 0v4m-8 4h8"/>
        </svg>
        Results
    </a>


</nav>


            <!-- Logout -->
            <div class="p-4 border-t border-green-600">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-3 rounded-lg hover:bg-red-600 transition">
                        <svg class="h-6 w-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m0 0H5m8 0h8"/>
                        </svg>
                        <span class="text-red-500 hover:text-white font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Header -->
            <header class="bg-white shadow flex justify-between items-center px-6 py-4 sticky top-0 z-20">
                <h1 class="text-xl font-semibold text-green-700">{{ $header ?? 'Admin Dashboard' }}</h1>

                <div class="flex items-center space-x-4">
                    @php
                        $admin = Auth::guard('admin')->user() ?? Auth::user();
                        $name = $admin ? ($admin->name ?? 'Admin') : 'Admin';
                    @endphp
                    <span class="text-gray-700 hidden sm:inline">{{ $name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=16a34a&color=fff" alt="avatar" class="w-10 h-10 rounded-full border-2 border-green-600 shadow-sm">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @livewireScripts
</body>
</html>
