<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blood Bank Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .blood-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        }
        .blood-pattern {
            background-color: #fef2f2;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fee2e2' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen blood-pattern">
    <!-- Navigation -->
    <nav class="blood-gradient shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                    </svg>
                    <div>
                        <h1 class="text-white text-xl font-bold">Blood Bank</h1>
                        <p class="text-red-100 text-xs">Management System</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <a href="{{ route('blood-bank.dashboard') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.dashboard') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Dashboard</span>
                        </span>
                    </a>
                    <a href="{{ route('blood-bank.inventory') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.inventory') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <span>Inventory</span>
                        </span>
                    </a>
                    <a href="{{ route('blood-bank.donors') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.donors') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Donors</span>
                        </span>
                    </a>
                    <a href="{{ route('blood-bank.distributions') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.distributions') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            <span>Distributions</span>
                        </span>
                    </a>
                    <a href="{{ route('blood-bank.partners') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.partners') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Partners</span>
                        </span>
                    </a>
                    <a href="{{ route('blood-bank.alerts') }}" 
                       class="text-white hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('blood-bank.alerts') ? 'bg-red-800' : '' }}">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span>Alerts</span>
                        </span>
                    </a>
                    @if(auth()->check())
                        <div class="ml-4 flex items-center space-x-3 border-l border-red-400 pl-4">
                            <div class="text-right">
                                <p class="text-white text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-red-100 text-xs">{{ auth()->user()->role }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-white text-red-600 hover:bg-red-50 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-white text-red-600 hover:bg-red-50 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} Blood Bank Management System. Saving Lives, One Donation at a Time.</p>
            </div>
        </div>
    </footer>
</body>
</html>
