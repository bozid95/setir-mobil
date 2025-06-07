<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Driving School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg no-print">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-car text-3xl text-blue-600 mr-3"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Driving School</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-home mr-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-6 py-8">
        <!-- Success Message -->
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-green-800">Registration Successful!</h3>
                    <p class="text-green-700 mt-1">Your driving course registration has been completed. Please save your
                        unique code and payment details below.</p>
                </div>
            </div>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Order Details</h2>
                <div class="bg-blue-100 text-blue-800 px-6 py-3 rounded-lg font-mono font-bold text-xl inline-block">
                    <i class="fas fa-code mr-2"></i>{{ $student->unique_code }}
                </div>
                <p class="text-gray-600 mt-2">Please save this unique code for tracking your progress</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Student Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-user text-blue-600 mr-2"></i>Student Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-semibold">{{ $student->name }}</span>
                        </div>
                        @if ($student->email)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold">{{ $student->email }}</span>
                            </div>
                        @endif
                        @if ($student->phone_number)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-semibold">{{ $student->phone_number }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registration Date:</span>
                            <span
                                class="font-semibold">{{ $student->register_date ? $student->register_date->format('d M Y') : 'Today' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Package Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>Package Details
                    </h3>
                    @if ($student->package)
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Package:</span>
                                <span class="font-semibold">{{ $student->package->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold">{{ $student->package->duration_weeks }} weeks</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Description:</span>
                                <span class="font-semibold text-right">{{ $student->package->description }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-blue-600 border-t pt-3">
                                <span>Total Amount:</span>
                                <span>Rp {{ number_format($student->package->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                <i class="fas fa-credit-card text-blue-600 mr-2"></i>Payment Instructions
            </h2>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-yellow-700">
                            <strong>Important:</strong> Please complete your payment within 24 hours to secure your
                            slot. Your registration will be processed after payment confirmation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-university text-blue-600 mr-2"></i>Bank Transfer Details
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bank Name:</span>
                            <span class="font-bold">{{ $bankDetails['bank_name'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Number:</span>
                            <span class="font-bold font-mono text-lg">{{ $bankDetails['account_number'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Name:</span>
                            <span class="font-bold">{{ $bankDetails['account_name'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Branch:</span>
                            <span class="font-bold">{{ $bankDetails['branch'] }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Amount to Transfer:</span>
                            <span class="font-bold text-xl text-blue-600">Rp
                                {{ number_format($student->package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Reference Code:</span>
                            <span class="font-bold font-mono">{{ $student->unique_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="font-bold text-orange-600">Pending</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-white rounded border">
                    <h4 class="font-semibold text-gray-800 mb-2">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Transfer Instructions:
                    </h4>
                    <ol class="list-decimal list-inside text-gray-700 space-y-1">
                        <li>Transfer the exact amount: <strong>Rp
                                {{ number_format($student->package->price, 0, ',', '.') }}</strong></li>
                        <li>Use your unique code <strong>{{ $student->unique_code }}</strong> as the transfer reference
                        </li>
                        <li>Keep your transfer receipt as proof of payment</li>
                        <li>WhatsApp us the receipt to <strong>+62 812-3456-7890</strong></li>
                        <li>Payment will be verified within 2-4 hours</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row gap-4 justify-center no-print">
            <button onclick="window.print()"
                class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition flex items-center justify-center">
                <i class="fas fa-print mr-2"></i>Print Order Details
            </button>

            <a href="{{ route('student.dashboard', ['code' => $student->unique_code]) }}"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                <i class="fas fa-dashboard mr-2"></i>Go to Student Dashboard
            </a>

            <a href="{{ route('landing.index') }}"
                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
                <i class="fas fa-phone text-blue-600 mr-2"></i>Need Help?
            </h3>
            <div class="text-center space-y-2">
                <p class="text-gray-600">WhatsApp: <strong>+62 812-3456-7890</strong></p>
                <p class="text-gray-600">Email: <strong>info@drivingschool.com</strong></p>
                <p class="text-gray-600">Office Hours: Monday - Saturday, 08:00 - 17:00</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus on unique code for easy copying
        document.addEventListener('DOMContentLoaded', function() {
            // Add copy to clipboard functionality
            const uniqueCode = '{{ $student->unique_code }}';
            const accountNumber = '{{ $bankDetails['account_number'] }}';

            // You can add copy to clipboard buttons here if needed
        });
    </script>
</body>

</html>
