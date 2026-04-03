<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System - Saving Lives Together</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), url('/blood_donation.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            background-repeat: no-repeat;
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-delay {
            animation: fadeIn 1s ease-in 0.3s both;
        }
        .animate-fade-in-delay-2 {
            animation: fadeIn 1s ease-in 0.6s both;
        }
        .blood-drop {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateX(0px); }
            50% { transform: translateX(-20px); }
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center justify-center relative">
        <!-- Navigation Bar -->
        <nav class="absolute top-0 left-0 right-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-lg blood-drop">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-white text-xl font-bold">Blood Bank System</h1>
                            <p class="text-red-200 text-xs">Saving Lives Together</p>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#mission" class="text-white hover:text-red-300 font-medium transition-colors">Mission</a>
                        <a href="#about" class="text-white hover:text-red-300 font-medium transition-colors">About</a>
                        <a href="#learn" class="text-white hover:text-red-300 font-medium transition-colors">Learn</a>
                        <a href="#faq" class="text-white hover:text-red-300 font-medium transition-colors">FAQ</a>
                        <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-semibold shadow-lg transition-all transform hover:scale-105">
                            Sign In
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-semibold shadow-lg transition-all">
                            Sign In
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Every Drop Counts.<br>
                    <span class="text-red-400">Every Life Matters.</span>
                </h1>
            </div>
            <div class="animate-fade-in-delay">
                <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto">
                    Connecting blood banks, donors, and healthcare facilities through intelligent management and real-time collaboration.
                </p>
            </div>
            <div class="animate-fade-in-delay-2 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('login') }}" class="group bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-2xl transition-all transform hover:scale-105 flex items-center space-x-2">
                    <span>Get Started</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#features" class="backdrop-blur-sm hover:bg-opacity-30 text-white px-8 py-4 rounded-full font-bold text-lg border-2 border-white transition-all bg-transparent">
                    Learn More
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="py-20 bg-gradient-to-br from-red-600 to-red-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Our Mission</h2>
                <p class="text-xl text-red-100 max-w-3xl mx-auto mb-12">
                    To save lives by connecting donors, blood banks, and healthcare facilities through innovative technology and seamless collaboration.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white mb-2" style="color: black">Ensure Availability</h3>
                            <p class="text-gray-800">Maintain adequate blood supply for all emergencies and planned procedures through intelligent inventory management.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white mb-2" style="color: black">Enable Collaboration</h3>
                            <p class="text-gray-800">Connect blood banks in a network to share resources and respond quickly to critical shortages.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white mb-2" style="color: black">Save Time</h3>
                            <p class="text-gray-800">Streamline operations with automated tracking, alerts, and distribution management to respond faster to emergencies.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white mb-2" style="color: black" >Improve Safety</h3>
                            <p class="text-gray-800">Reduce errors with verified blood type matching, expiry tracking, and comprehensive screening records.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">About Our System</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Our Blood Bank Management System is a comprehensive platform designed to revolutionize how blood banks operate and collaborate. Built with cutting-edge technology and real-world insights from healthcare professionals.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Real-Time Inventory Tracking</h3>
                                <p class="text-gray-600">Monitor blood units across all types with live updates on availability, expiry dates, and status.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Multi-Establishment Network</h3>
                                <p class="text-gray-600">Connect with partner blood banks to share inventory information and collaborate during shortages.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Smart Alerts & Notifications</h3>
                                <p class="text-gray-600">Automated alerts for low stock, expiring units, and critical situations to prevent waste and shortages.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-2xl p-12 text-center">
                    <div class="blood-drop">
                        <svg class="w-32 h-32 mx-auto text-red-600 mb-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Trusted by Healthcare Professionals</h3>
                    <p class="text-gray-700">Designed with input from blood bank managers, medical staff, and IT specialists to meet real-world needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Streamline your blood bank operations with our comprehensive management system
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="group bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Inventory Management</h3>
                    <p class="text-gray-600">
                        Real-time tracking of blood units, expiry dates, and stock levels across all blood types.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Donor Management</h3>
                    <p class="text-gray-600">
                        Comprehensive donor registry with medical history, eligibility tracking, and donation records.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Partner Network</h3>
                    <p class="text-gray-600">
                        Connect with other blood banks, share inventory data, and collaborate to save more lives.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Distribution Tracking</h3>
                    <p class="text-gray-600">
                        Manage blood unit reservations, patient assignments, and hospital department distributions.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-amber-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Smart Alerts</h3>
                    <p class="text-gray-600">
                        Automated notifications for low stock, expiring units, and critical supply shortages.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-8 hover:shadow-2xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Analytics Dashboard</h3>
                    <p class="text-gray-600">
                        Comprehensive insights into donations, usage patterns, and blood bank performance metrics.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Learn Section - Blood Types & Compatibility -->
    <section id="learn" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Blood Types & Compatibility</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Understanding blood types is crucial for safe transfusions. Learn about the different blood groups and their compatibility.
                </p>
            </div>

            <!-- Blood Type Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-12">
                @php
                    $bloodTypes = [
                        ['type' => 'O-', 'color' => 'red', 'title' => 'Universal Donor'],
                        ['type' => 'O+', 'color' => 'orange'],
                        ['type' => 'A-', 'color' => 'blue'],
                        ['type' => 'A+', 'color' => 'indigo'],
                        ['type' => 'B-', 'color' => 'purple'],
                        ['type' => 'B+', 'color' => 'yellow'],
                        ['type' => 'AB-', 'color' => 'pink'],
                        ['type' => 'AB+', 'color' => 'green', 'title' => 'Universal Recipient'],
                    ];
                @endphp
                @foreach($bloodTypes as $bt)
                    <div class="text-center group">
                        <div class="bg-{{ $bt['color'] }}-100 border-2 border-{{ $bt['color'] }}-300 rounded-xl p-6 hover:shadow-lg transition-all transform hover:scale-105">
                            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-{{ $bt['color'] }}-500 to-{{ $bt['color'] }}-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md mb-3">
                                {{ $bt['type'] }}
                            </div>
                            @if(isset($bt['title']))
                                <p class="text-xs font-semibold text-{{ $bt['color'] }}-700">{{ $bt['title'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Compatibility Chart -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Blood Type Compatibility Chart</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Blood Type</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Can Donate To</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Can Receive From</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-red-50 transition-colors">
                                <td class="px-4 py-4">
                                    <span class="font-bold text-red-600 text-lg">O-</span>
                                    <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Universal Donor</span>
                                </td>
                                <td class="px-4 py-4 text-center">All blood types</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-</span></td>
                            </tr>
                            <tr class="hover:bg-orange-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-orange-600 text-lg">O+</span></td>
                                <td class="px-4 py-4 text-center">O+, A+, B+, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, O+</span></td>
                            </tr>
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-blue-600 text-lg">A-</span></td>
                                <td class="px-4 py-4 text-center">A-, A+, AB-, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, A-</span></td>
                            </tr>
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-indigo-600 text-lg">A+</span></td>
                                <td class="px-4 py-4 text-center">A+, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, O+, A-, A+</span></td>
                            </tr>
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-purple-600 text-lg">B-</span></td>
                                <td class="px-4 py-4 text-center">B-, B+, AB-, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, B-</span></td>
                            </tr>
                            <tr class="hover:bg-pink-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-yellow-600 text-lg">B+</span></td>
                                <td class="px-4 py-4 text-center">B+, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, O+, B-, B+</span></td>
                            </tr>
                            <tr class="hover:bg-emerald-50 transition-colors">
                                <td class="px-4 py-4"><span class="font-bold text-pink-600 text-lg">AB-</span></td>
                                <td class="px-4 py-4 text-center">AB-, AB+</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">O-, A-, B-, AB-</span></td>
                            </tr>
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-4 py-4">
                                    <span class="font-bold text-green-600 text-lg">AB+</span>
                                    <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Universal Recipient</span>
                                </td>
                                <td class="px-4 py-4 text-center">AB+ only</td>
                                <td class="px-4 py-4 text-center"><span class="font-semibold">All blood types</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Key Facts -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-red-200 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-2">Why Blood Types Matter</h4>
                    <p class="text-red-100">Matching blood types prevents dangerous immune reactions during transfusions. The body recognizes incompatible blood as foreign and attacks it.</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-blue-200 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-2">The Rh Factor</h4>
                    <p class="text-blue-100">The + or - indicates the Rh factor. Rh- blood can be given to both Rh+ and Rh- patients, but Rh+ blood should only go to Rh+ patients.</p>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-green-200 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-2">O- is Precious</h4>
                    <p class="text-emerald-100">O- blood can be given to anyone in emergencies when there's no time to determine blood type. Only 7% of the population has O- blood.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-gradient-to-br from-red-600 to-red-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="blood-drop">
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <div class="text-red-200 text-lg">System Availability</div>
                </div>
                <div class="blood-drop" style="animation-delay: 0.2s">
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <div class="text-red-200 text-lg">Data Security</div>
                </div>
                <div class="blood-drop" style="animation-delay: 0.4s">
                    <div class="text-5xl font-bold mb-2">Real-Time</div>
                    <div class="text-red-200 text-lg">Inventory Tracking</div>
                </div>
                <div class="blood-drop" style="animation-delay: 0.6s">
                    <div class="text-5xl font-bold mb-2">Multi-Site</div>
                    <div class="text-red-200 text-lg">Collaboration</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Ready to Make a Difference?
            </h2>
            <p class="text-xl text-gray-600 mb-10">
                Join our network of blood banks working together to save lives every day.
            </p>
            <a href="{{ route('login') }}" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-10 py-4 rounded-full font-bold text-lg shadow-2xl transition-all transform hover:scale-105 space-x-2">
                <span>Access the System</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Blood Bank System</p>
                            <p class="text-gray-400 text-sm">Saving Lives Together</p>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400">&copy; {{ date('Y') }} Blood Bank Management System</p>
                    <p class="text-gray-500 text-sm mt-1">Every donation counts. Every life matters.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
