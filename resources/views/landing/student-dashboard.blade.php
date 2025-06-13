<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-car text-3xl text-blue-600 mr-3"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Driving School</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, {{ $student->name }}</span>
                    <a href="{{ route('landing.index') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-home mr-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8">
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Student Dashboard</h2>
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg font-mono font-bold">
                    <i class="fas fa-code mr-2"></i>{{ $student->unique_code }}
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-blue-600 w-5 mr-3"></i>
                            <span class="text-gray-700">{{ $student->name }}</span>
                        </div>
                        @if ($student->email)
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $student->email }}</span>
                            </div>
                        @endif
                        @if ($student->phone_number)
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $student->phone_number }}</span>
                            </div>
                        @endif
                        @if ($student->address)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700">{{ $student->address }}</span>
                            </div>
                        @endif
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-blue-600 w-5 mr-3"></i>
                            <span class="text-gray-700">Registered:
                                {{ $student->register_date ? $student->register_date->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        @if ($student->gender)
                            <div class="flex items-center">
                                <i class="fas fa-venus-mars text-blue-600 w-5 mr-3"></i>
                                <span class="text-gray-700 capitalize">{{ $student->gender }}</span>
                            </div>
                        @endif
                        @if ($student->date_of_birth)
                            <div class="flex items-center">
                                <i class="fas fa-birthday-cake text-blue-600 w-5 mr-3"></i>
                                <span
                                    class="text-gray-700">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('M j, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Package Information</h3>
                    @if ($student->package)
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">{{ $student->package->name }}</h4>
                            <p class="text-blue-600 text-sm mb-2">{{ $student->package->description }}</p>
                            <div class="text-sm text-blue-700">
                                <div>Duration: {{ $student->package->duration_weeks }} weeks</div>
                                <div>Price: Rp {{ number_format($student->package->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
                            No package assigned yet
                        </div>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Instructor Information</h3>
                    @if (isset($instructor) && $instructor)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">{{ $instructor->name }}</h4>
                            @if ($instructor->email)
                                <p class="text-green-600 text-sm mb-1">
                                    <i class="fas fa-envelope mr-1"></i>{{ $instructor->email }}
                                </p>
                            @endif
                            @if ($instructor->phone)
                                <p class="text-green-600 text-sm">
                                    <i class="fas fa-phone mr-1"></i>{{ $instructor->phone }}
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
                            <i class="fas fa-user-tie text-2xl mb-2"></i>
                            <p>No instructor assigned yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Progress</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $progressPercentage }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $completedSessions }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Sessions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalSessions }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div
                        class="p-3 rounded-full {{ $outstandingPayment > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Outstanding</p>
                        <p class="text-lg font-semibold text-gray-900">Rp
                            {{ number_format($outstandingPayment, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Learning Progress</h3>
            <div class="mb-2 flex justify-between">
                <span class="text-sm font-medium text-blue-700">{{ $completedSessions }} of {{ $totalSessions }}
                    sessions completed</span>
                <span class="text-sm font-medium text-blue-700">{{ $progressPercentage }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                    style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Sessions History -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Sessions History</h3>
                @if ($student->studentSessions->count() > 0)
                    <div class="space-y-4">
                        @foreach ($student->studentSessions->take(5) as $studentSession)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-800">
                                        {{ $studentSession->session->name ?? 'Session #' . $studentSession->id }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $studentSession->scheduled_date ? \Carbon\Carbon::parse($studentSession->scheduled_date)->format('d M Y, H:i') : 'No date scheduled' }}
                                    </p>
                                    @if ($studentSession->instructor)
                                        <p class="text-xs text-blue-600">
                                            <i
                                                class="fas fa-user-tie mr-1"></i>{{ $studentSession->instructor->name }}
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    @switch($studentSession->status)
                                        @case('completed')
                                            <span
                                                class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Completed
                                            </span>
                                        @break

                                        @case('scheduled')
                                            <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Scheduled
                                            </span>
                                        @break

                                        @case('cancelled')
                                            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                <i class="fas fa-times mr-1"></i>Cancelled
                                            </span>
                                        @break

                                        @case('missed')
                                            <span
                                                class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                <i class="fas fa-exclamation mr-1"></i>Missed
                                            </span>
                                        @break

                                        @default
                                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                {{ ucfirst($studentSession->status) }}
                                            </span>
                                    @endswitch
                                </div>
                            </div>
                        @endforeach

                        @if ($student->studentSessions->count() > 5)
                            <div class="text-center pt-4">
                                <span class="text-sm text-gray-500">And {{ $student->studentSessions->count() - 5 }}
                                    more
                                    sessions...</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-4"></i>
                        <p>No sessions scheduled yet</p>
                    </div>
                @endif
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Payment Information</h3>
                @if ($student->finances->count() > 0)
                    <div class="space-y-4">
                        @foreach ($student->finances->take(5) as $finance)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $finance->description }}</h4>
                                    <p class="text-sm text-gray-600">{{ $finance->created_at->format('M j, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-blue-600">
                                        Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 capitalize">{{ $finance->type }}</p>
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
                        @endforeach
                    </div>

                    <!-- Payment Summary -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Total Amount:</span>
                            <span class="font-semibold text-gray-800">Rp
                                {{ number_format($totalPaymentDue, 0, ',', '.') }}</span>
                        </div>
                        @if ($student->finances->count() > 0)
                            <div class="text-sm text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $student->finances->count() }} payment record(s) found
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-receipt text-4xl mb-4"></i>
                        <p>No payment records found</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Instructor Information -->
        @if ($student->instructor)
            <div class="bg-white rounded-lg shadow-lg p-6 mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Your Instructor</h3>
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800">{{ $student->instructor->name }}</h4>
                        <p class="text-gray-600">{{ $student->instructor->email }}</p>
                        <p class="text-gray-600">{{ $student->instructor->phone_number }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <script>
        // Auto-hide success messages
        setTimeout(() => {
            const messages = document.querySelectorAll('.fixed.bottom-4.right-4');
            messages.forEach(msg => msg.style.display = 'none');
        }, 8000);
    </script>
</body>

</html>
