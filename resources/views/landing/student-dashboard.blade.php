<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'pulse-soft': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen">
    <!-- Header -->
    <header class="glassmorphism shadow-xl sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div class="flex items-center mb-3 sm:mb-0">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl mr-3">
                        <i class="fas fa-car text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h1
                        class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Driving School
                    </h1>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <span class="text-gray-600 text-sm sm:text-base">
                        Welcome, <span class="font-semibold text-gray-800">{{ $student->name }}</span>
                    </span>
                    <a href="{{ route('landing.index') }}"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 sm:px-4 py-2 rounded-lg transition-all duration-300 text-sm sm:text-base flex items-center justify-center transform hover:scale-105">
                        <i class="fas fa-home mr-1 sm:mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-8">
        <!-- Student Info Card -->
        <div class="animate-bounce-in glassmorphism rounded-2xl shadow-xl p-4 sm:p-6 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                <h2
                    class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-3 sm:mb-0">
                    🎯 Student Dashboard
                </h2>
                <div
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 sm:px-4 py-2 rounded-xl font-mono font-bold text-sm sm:text-base">
                    <i class="fas fa-code mr-2"></i>{{ $student->unique_code }}
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Personal Information -->
                <div
                    class="animate-slide-up bg-gradient-to-br from-blue-50 to-indigo-50 p-4 sm:p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b border-blue-200 pb-2">
                        <i class="fas fa-user text-blue-600 mr-2"></i>Personal Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-blue-600 w-5 mr-3"></i>
                            <span class="text-gray-700 text-sm sm:text-base">{{ $student->name }}</span>
                        </div>
                        @if ($student->email)
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700 text-sm sm:text-base break-all">{{ $student->email }}</span>
                            </div>
                        @endif
                        @if ($student->phone_number)
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700 text-sm sm:text-base">{{ $student->phone_number }}</span>
                            </div>
                        @endif
                        @if ($student->address)
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-600 w-5 mr-3 mt-1"></i>
                                <span class="text-gray-700 text-sm sm:text-base">{{ $student->address }}</span>
                            </div>
                        @endif
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-blue-600 w-5 mr-3"></i>
                            <span class="text-gray-700 text-sm sm:text-base">Registered:
                                {{ $student->register_date ? $student->register_date->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        @if ($student->gender)
                            <div class="flex items-center">
                                <i class="fas fa-venus-mars text-blue-600 w-5 mr-3"></i>
                                <span
                                    class="text-gray-700 text-sm sm:text-base capitalize">{{ $student->gender }}</span>
                            </div>
                        @endif
                        @if ($student->date_of_birth)
                            <div class="flex items-center">
                                <i class="fas fa-birthday-cake text-blue-600 w-5 mr-3"></i>
                                <span
                                    class="text-gray-700 text-sm sm:text-base">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('M j, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Package Information -->
                <div class="animate-slide-up bg-gradient-to-br from-purple-50 to-pink-50 p-4 sm:p-6 rounded-xl border border-purple-100"
                    style="animation-delay: 0.1s;">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b border-purple-200 pb-2">
                        <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>Package Information
                    </h3>
                    @if ($student->package)
                        <div
                            class="bg-gradient-to-r from-purple-100 to-pink-100 p-4 rounded-lg border border-purple-200">
                            <h4 class="font-bold text-purple-800 mb-2 text-sm sm:text-base">
                                {{ $student->package->name }}</h4>
                            <p class="text-purple-600 text-xs sm:text-sm mb-2">{{ $student->package->description }}</p>
                            <div class="text-xs sm:text-sm text-purple-700 space-y-1">
                                <div class="flex justify-between">
                                    <span>Duration:</span>
                                    <span class="font-semibold">{{ $student->package->duration_weeks }} weeks</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Price:</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($student->package->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-500">
                            <i class="fas fa-box-open text-2xl mb-2"></i>
                            <p class="text-sm">No package assigned yet</p>
                        </div>
                    @endif
                </div>

                <!-- Instructor Information -->
                <div class="animate-slide-up bg-gradient-to-br from-green-50 to-emerald-50 p-4 sm:p-6 rounded-xl border border-green-100"
                    style="animation-delay: 0.2s;">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b border-green-200 pb-2">
                        <i class="fas fa-user-tie text-green-600 mr-2"></i>Instructor Information
                    </h3>
                    @if (isset($instructor) && $instructor)
                        <div
                            class="bg-gradient-to-r from-green-100 to-emerald-100 p-4 rounded-lg border border-green-200">
                            <h4 class="font-bold text-green-800 mb-2 text-sm sm:text-base">{{ $instructor->name }}</h4>
                            @if ($instructor->email)
                                <p class="text-green-600 text-xs sm:text-sm mb-1 break-all">
                                    <i class="fas fa-envelope mr-1"></i>{{ $instructor->email }}
                                </p>
                            @endif
                            @if ($instructor->phone)
                                <p class="text-green-600 text-xs sm:text-sm">
                                    <i class="fas fa-phone mr-1"></i>{{ $instructor->phone }}
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-500">
                            <i class="fas fa-user-tie text-2xl mb-2"></i>
                            <p class="text-sm">No instructor assigned yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="animate-slide-up glassmorphism rounded-xl shadow-lg p-4 sm:p-6 border border-blue-100"
                style="animation-delay: 0.3s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <i class="fas fa-graduation-cap text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Progress</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $progressPercentage }}%</p>
                    </div>
                </div>
            </div>

            <div class="animate-slide-up glassmorphism rounded-xl shadow-lg p-4 sm:p-6 border border-green-100"
                style="animation-delay: 0.4s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                        <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $completedSessions }}</p>
                    </div>
                </div>
            </div>

            <div class="animate-slide-up glassmorphism rounded-xl shadow-lg p-4 sm:p-6 border border-yellow-100 sm:col-span-2 lg:col-span-1"
                style="animation-delay: 0.5s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-yellow-500 to-orange-600 text-white">
                        <i class="fas fa-clock text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Sessions</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalSessions }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="animate-slide-up glassmorphism rounded-2xl shadow-xl p-4 sm:p-6 mb-6 sm:mb-8 border border-blue-100"
            style="animation-delay: 0.6s;">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>Learning Progress
            </h3>
            <div class="mb-3 flex flex-col sm:flex-row sm:justify-between text-sm sm:text-base">
                <span class="font-medium text-blue-700 mb-1 sm:mb-0">{{ $completedSessions }} of {{ $totalSessions }}
                    sessions completed</span>
                <span class="font-bold text-blue-700">{{ $progressPercentage }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 sm:h-4 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-1000 ease-out animate-pulse-soft"
                    style="width: {{ $progressPercentage }}%"></div>
            </div>
            <div class="mt-2 text-xs text-gray-600 text-center">
                @if ($progressPercentage == 100)
                    🎉 Congratulations! You've completed all sessions!
                @elseif($progressPercentage >= 75)
                    🚀 Almost there! Keep up the great work!
                @elseif($progressPercentage >= 50)
                    💪 You're halfway through! Keep going!
                @elseif($progressPercentage >= 25)
                    📚 Good start! Continue your learning journey!
                @else
                    🌟 Welcome! Your learning adventure begins here!
                @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-4 sm:gap-8">
            <!-- Sessions History -->
            <div class="animate-slide-up glassmorphism rounded-2xl shadow-xl p-4 sm:p-6 border border-purple-100"
                style="animation-delay: 0.7s;">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-6">
                    <i class="fas fa-history text-purple-600 mr-2"></i>Sessions History
                </h3>
                @if ($student->studentSessions->count() > 0)
                    <div class="space-y-3 sm:space-y-4">
                        @foreach ($student->studentSessions->take(5) as $studentSession)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 sm:p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                                <div class="mb-2 sm:mb-0">
                                    <h4 class="font-semibold text-gray-800 text-sm sm:text-base">
                                        {{ $studentSession->session->name ?? 'Session #' . $studentSession->id }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        {{ $studentSession->scheduled_date ? \Carbon\Carbon::parse($studentSession->scheduled_date)->format('d M Y, H:i') : 'No date scheduled' }}
                                    </p>
                                    @if ($studentSession->instructor)
                                        <p class="text-xs text-purple-600">
                                            <i
                                                class="fas fa-user-tie mr-1"></i>{{ $studentSession->instructor->name }}
                                        </p>
                                    @endif
                                </div>
                                <div class="self-start sm:self-center">
                                    @switch($studentSession->status)
                                        @case('completed')
                                            <span
                                                class="px-2 sm:px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Completed
                                            </span>
                                        @break

                                        @case('scheduled')
                                            <span
                                                class="px-2 sm:px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Scheduled
                                            </span>
                                        @break

                                        @case('cancelled')
                                            <span
                                                class="px-2 sm:px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                <i class="fas fa-times mr-1"></i>Cancelled
                                            </span>
                                        @break

                                        @case('missed')
                                            <span
                                                class="px-2 sm:px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                <i class="fas fa-exclamation mr-1"></i>Missed
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2 sm:px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                {{ ucfirst($studentSession->status) }}
                                            </span>
                                    @endswitch
                                </div>
                            </div>
                        @endforeach

                        @if ($student->studentSessions->count() > 5)
                            <div class="text-center pt-4">
                                <span class="text-xs sm:text-sm text-gray-500">And
                                    {{ $student->studentSessions->count() - 5 }} more sessions...</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-6 sm:py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-3xl sm:text-4xl mb-4 text-purple-300"></i>
                        <p class="text-sm sm:text-base">No sessions scheduled yet</p>
                        <p class="text-xs sm:text-sm mt-1">Your sessions will appear here once scheduled</p>
                    </div>
                @endif
            </div>

            <!-- Payment Information -->
            <div class="animate-slide-up glassmorphism rounded-2xl shadow-xl p-4 sm:p-6 border border-green-100"
                style="animation-delay: 0.8s;">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-6">
                    <i class="fas fa-wallet text-green-600 mr-2"></i>Payment Information
                </h3>
                @if ($student->finances->count() > 0)
                    <div class="space-y-3 sm:space-y-4">
                        @foreach ($student->finances->take(5) as $finance)
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 sm:p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                                <div class="mb-2 sm:mb-0">
                                    <h4 class="font-semibold text-gray-800 text-sm sm:text-base">
                                        {{ $finance->description }}</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        {{ $finance->created_at->format('M j, Y') }}</p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="font-bold text-green-600 text-sm sm:text-base">
                                        Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 capitalize">{{ $finance->type }}</p>
                                    <div class="mt-1">
                                        @if (isset($finance->status))
                                            @switch($finance->status)
                                                @case('paid')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                        <i class="fas fa-check mr-1"></i>Paid
                                                    </span>
                                                @break

                                                @case('pending')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                        <i class="fas fa-clock mr-1"></i>Pending
                                                    </span>
                                                @break

                                                @case('overdue')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                        <i class="fas fa-exclamation mr-1"></i>Overdue
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                        {{ ucfirst($finance->status) }}
                                                    </span>
                                            @endswitch
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                <i class="fas fa-money-bill mr-1"></i>{{ ucfirst($finance->type) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Payment Summary -->
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-green-200">
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 p-3 sm:p-4 rounded-xl">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2">
                                <span class="text-sm text-gray-600 font-medium">Total Amount:</span>
                                <span class="font-bold text-lg text-green-700">Rp
                                    {{ number_format($totalPaymentDue, 0, ',', '.') }}</span>
                            </div>
                            @if ($student->finances->count() > 0)
                                <div class="text-xs sm:text-sm text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ $student->finances->count() }} payment record(s) found
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-6 sm:py-8 text-gray-500">
                        <i class="fas fa-receipt text-3xl sm:text-4xl mb-4 text-green-300"></i>
                        <p class="text-sm sm:text-base">No payment records found</p>
                        <p class="text-xs sm:text-sm mt-1">Payment history will appear here</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Instructor Information (if different from header) -->
        @if (isset($student->instructor) &&
                $student->instructor &&
                (!isset($instructor) || $instructor->id != $student->instructor->id))
            <div class="animate-slide-up glassmorphism rounded-2xl shadow-xl p-4 sm:p-6 mt-6 sm:mt-8 border border-blue-100"
                style="animation-delay: 0.9s;">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-6">
                    <i class="fas fa-user-tie text-blue-600 mr-2"></i>Your Primary Instructor
                </h3>
                <div
                    class="flex flex-col sm:flex-row sm:items-center bg-gradient-to-r from-blue-50 to-indigo-50 p-4 sm:p-6 rounded-xl">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                        <i class="fas fa-user-tie text-lg sm:text-2xl text-white"></i>
                    </div>
                    <div class="text-center sm:text-left">
                        <h4 class="text-base sm:text-lg font-bold text-gray-800">{{ $student->instructor->name }}</h4>
                        <p class="text-gray-600 text-sm sm:text-base">{{ $student->instructor->email }}</p>
                        <p class="text-gray-600 text-sm sm:text-base">{{ $student->instructor->phone_number }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Success Messages -->
    @if (session('success'))
        <div
            class="fixed top-4 right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 sm:px-6 py-3 rounded-xl shadow-2xl z-50 transform transition-all duration-300">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <script>
        // Enhanced success message with slide animations
        setTimeout(() => {
            const messages = document.querySelectorAll('.fixed.top-4.right-4');
            messages.forEach(msg => {
                msg.style.transform = 'translateX(100%)';
                msg.style.opacity = '0';
                setTimeout(() => {
                    if (msg.parentNode) {
                        msg.style.display = 'none';
                    }
                }, 300);
            });
        }, 5000);

        // Page load animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add stagger animations to elements
            const animatedElements = document.querySelectorAll('.animate-slide-up');
            animatedElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Progress bar animation
            const progressBar = document.querySelector('[style*="width: {{ $progressPercentage }}%"]');
            if (progressBar) {
                setTimeout(() => {
                    progressBar.style.width = '{{ $progressPercentage }}%';
                }, 500);
            }
        });

        // Add interactive hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.glassmorphism');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
</body>

</html>
