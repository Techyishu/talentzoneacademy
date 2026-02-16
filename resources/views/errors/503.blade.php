<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - TalentZone Academy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- 503 Illustration -->
        <div class="mb-8">
            <svg class="w-64 h-64 mx-auto text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>

        <!-- Maintenance Message -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-200">
            <h1 class="text-6xl font-bold text-gray-900 mb-4">503</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Under Maintenance</h2>
            <p class="text-gray-600 mb-8">
                We're currently performing scheduled maintenance to improve your experience. We'll be back shortly!
            </p>

            <!-- Maintenance Progress -->
            <div class="mb-8">
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="bg-amber-500 h-2 rounded-full animate-pulse" style="width: 65%"></div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Estimated completion: Soon</p>
            </div>

            <!-- Action Button -->
            <button
                onclick="window.location.reload()"
                class="inline-flex items-center justify-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-150"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh Page
            </button>
        </div>

        <!-- Error Code -->
        <p class="mt-8 text-sm text-gray-500">
            Error Code: 503 | Service Unavailable
        </p>
    </div>
</body>
</html>
