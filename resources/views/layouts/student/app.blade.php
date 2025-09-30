<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Student Dashboard' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-700 text-white flex flex-col shadow-lg fixed h-screen">
        <!-- Logo / Title -->
         <div class="p-6 flex items-center justify-center border-b border-green-600 bg-green-800">
                <img src="{{ asset('images/fpi logo.png') }}" alt="FPI Logo" class="h-12 w-12 mr-3 rounded-full shadow-md object-cover">
                <span class="text-white text-2xl font-extrabold tracking-wide">FPI VOTE</span>
            </div>

        <!-- Links -->
        <nav class="flex-1 p-4 space-y-3">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-green-600">
                <i class="ph ph-gauge"></i> Dashboard
            </a>
            <a href="{{ route('student.vote') }}" class="flex items-center gap-2 p-2 rounded hover:bg-green-600">
                <i class="ph ph-check-circle"></i> Vote
            </a>
            <a href="{{ route('student.result') }}" class="flex items-center gap-2 p-2 rounded hover:bg-green-600">
                <i class="ph ph-chart-bar"></i> Results
            </a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-2 p-2 rounded hover:bg-red-600 mt-6">
                <i class="ph ph-sign-out"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64">
        <!-- Header -->
       <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">
                {{ $title ?? 'Dashboard' }}
            </h2>

            <div class="flex items-center space-x-3">
                <!-- User Initial -->
                @php
                    $user = Auth::guard('user')->user();
                    $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));
                @endphp
                <span class="w-10 h-10 flex items-center justify-center bg-green-600 text-white rounded-full font-bold">
                    {{ $initials }}
                </span>
                <span class="text-gray-700 font-medium">
                    {{ $user->first_name }} {{ $user->last_name }}
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gray-50">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
