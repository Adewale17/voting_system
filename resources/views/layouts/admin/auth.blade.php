<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Voting System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-green-50 via-green-100 to-green-200 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
        <!-- School Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/fpi logo.png') }}" alt="School Logo" class="h-16 w-16 object-contain">
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-green-700 mb-6">Admin Login</h1>

        <!-- Slot for the form -->
        {{ $slot }}

        <!-- Footer -->
        <div class="mt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} The Federal Polytechnic Ilaro. (Computer Science).
        </div>
    </div>

    @livewireScripts
</body>
</html>
