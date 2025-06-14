<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Driving School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-success': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
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

        @media print {
            .no-print {
                display: none;
            }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .success-glow {
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.3);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-lg no-print sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl mr-3">
                        <i class="fas fa-car text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h1
                        class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Driving School
                    </h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="{{ route('landing.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 sm:px-4 py-2 rounded-lg transition-all duration-300 text-sm sm:text-base flex items-center">
                        <i class="fas fa-home mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Back to</span> Home
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-8">
        <!-- Success Message with Animation -->
        <div
            class="animate-bounce-in success-glow bg-gradient-to-r from-green-400 to-emerald-500 text-white p-4 sm:p-6 rounded-2xl mb-6 sm:mb-8 shadow-xl">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl sm:text-3xl animate-pulse-success"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h3 class="text-lg sm:text-xl font-bold">🎉 Registration Successful!</h3>
                    <p class="text-green-50 mt-1 text-sm sm:text-base">Your driving course registration has been
                        completed. Please save your unique code and payment details below.</p>
                </div>
            </div>
        </div>

        <!-- Order Details Card -->
        <div
            class="animate-fade-in bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 sm:p-8 mb-6 sm:mb-8 border border-white/20">
            <div class="text-center mb-6 sm:mb-8">
                <h2
                    class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-4 sm:mb-6">
                    🎊 Registration Completed!
                </h2>

                <!-- Unique Code Display -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 sm:px-8 py-3 sm:py-4 rounded-xl font-mono font-bold text-lg sm:text-2xl inline-block shadow-xl cursor-pointer hover:from-blue-700 hover:to-indigo-700 transition-all transform hover:scale-105 active:scale-95"
                    onclick="copyToClipboard('{{ $student->unique_code }}')" title="Click to copy unique code">
                    <i class="fas fa-code mr-2 sm:mr-3"></i>{{ $student->unique_code }}
                    <i class="fas fa-copy ml-2 sm:ml-3 text-sm sm:text-lg"></i>
                </div>

                <p class="text-gray-600 mt-3 sm:mt-4 font-semibold text-sm sm:text-base">
                    🔒 This is your unique tracking code - keep it safe!
                </p>

                <!-- Info Box -->
                <div
                    class="mt-4 p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                        <p class="text-yellow-800 font-medium text-sm sm:text-base text-center">
                            Use this code to track your progress and access your student dashboard anytime
                        </p>
                    </div>
                </div>

                <!-- Direct Dashboard Access Button -->
                <div class="mt-4 sm:mt-6">
                    <a href="{{ route('student.dashboard', ['code' => $student->unique_code]) }}"
                        class="inline-flex items-center px-4 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg transform hover:scale-105 active:scale-95 text-sm sm:text-lg">
                        <i class="fas fa-tachometer-alt mr-2 sm:mr-3"></i>
                        <span>Access Your Dashboard Now</span>
                        <i class="fas fa-arrow-right ml-2 sm:ml-3"></i>
                    </a>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-4 sm:gap-8">
                <!-- Student Information -->
                <div
                    class="animate-slide-up bg-gradient-to-br from-blue-50 to-indigo-50 p-4 sm:p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b border-blue-200 pb-2">
                        <i class="fas fa-user text-blue-600 mr-2"></i>Student Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-gray-600 font-medium">Name:</span>
                            <span class="font-bold text-gray-800">{{ $student->name }}</span>
                        </div>
                        @if ($student->email)
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Email:</span>
                                <span class="font-bold text-gray-800 break-all">{{ $student->email }}</span>
                            </div>
                        @endif
                        @if ($student->phone_number)
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Phone:</span>
                                <span class="font-bold text-gray-800">{{ $student->phone_number }}</span>
                            </div>
                        @endif
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-gray-600 font-medium">Registration Date:</span>
                            <span
                                class="font-bold text-gray-800">{{ $student->register_date ? $student->register_date->format('d M Y') : 'Today' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Package Information -->
                <div class="animate-slide-up bg-gradient-to-br from-purple-50 to-pink-50 p-4 sm:p-6 rounded-xl border border-purple-100"
                    style="animation-delay: 0.1s;">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 border-b border-purple-200 pb-2">
                        <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>Package Details
                    </h3>
                    @if ($student->package)
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Package:</span>
                                <span class="font-bold text-gray-800">{{ $student->package->name }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Duration:</span>
                                <span class="font-bold text-gray-800">{{ $student->package->duration_weeks }}
                                    weeks</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Description:</span>
                                <span
                                    class="font-bold text-gray-800 text-right">{{ $student->package->description }}</span>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row sm:justify-between text-lg font-bold text-purple-600 border-t border-purple-200 pt-3">
                                <span>Total Amount:</span>
                                <span>Rp {{ number_format($student->package->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="animate-slide-up bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-4 sm:p-8 mb-6 sm:mb-8 border border-white/20"
            style="animation-delay: 0.2s;">
            <h2
                class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-4 sm:mb-6 text-center">
                <i class="fas fa-credit-card text-blue-600 mr-2"></i>Payment Instructions
            </h2>

            <div
                class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-3 sm:p-4 mb-4 sm:mb-6 rounded-r-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-yellow-800 text-sm sm:text-base">
                            <strong>Important:</strong> Please complete your payment within 24 hours to secure your
                            slot. Your registration will be processed after payment confirmation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 sm:p-6 rounded-xl border border-blue-200">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-university text-blue-600 mr-2"></i>Bank Transfer Details
                </h3>

                <div class="grid lg:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-3">
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Bank Name:</span>
                                <span class="font-bold text-gray-800">{{ $bankDetails['bank_name'] }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Account Number:</span>
                                <span
                                    class="font-bold font-mono text-lg text-blue-600">{{ $bankDetails['account_number'] }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Account Name:</span>
                                <span class="font-bold text-gray-800">{{ $bankDetails['account_name'] }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Branch:</span>
                                <span class="font-bold text-gray-800">{{ $bankDetails['branch'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            class="bg-gradient-to-r from-green-50 to-emerald-50 p-3 sm:p-4 rounded-lg border border-green-200">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Amount to Transfer:</span>
                                <span class="font-bold text-xl text-green-600">Rp
                                    {{ number_format($student->package->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-3 sm:p-4 rounded-lg border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Reference Code:</span>
                                <span class="font-bold font-mono text-blue-600">{{ $student->unique_code }}</span>
                            </div>
                        </div>
                        <div
                            class="bg-gradient-to-r from-orange-50 to-yellow-50 p-3 sm:p-4 rounded-lg border border-orange-200">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium">Payment Status:</span>
                                <span class="font-bold text-orange-600 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-6 p-4 sm:p-6 bg-white rounded-xl border border-blue-100">
                    <h4 class="font-bold text-gray-800 mb-3 text-lg">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Transfer Instructions:
                    </h4>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2 text-sm sm:text-base">
                        <li>Transfer the exact amount: <strong class="text-green-600">Rp
                                {{ number_format($student->package->price, 0, ',', '.') }}</strong></li>
                        <li>Use your unique code <strong
                                class="font-mono text-blue-600">{{ $student->unique_code }}</strong> as the transfer
                            reference</li>
                        <li>Keep your transfer receipt as proof of payment</li>
                        <li>WhatsApp us the receipt to <strong class="text-green-600">+62 812-3456-7890</strong></li>
                        <li>Payment will be verified within 2-4 hours</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="animate-slide-up flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center no-print mb-6 sm:mb-8"
            style="animation-delay: 0.3s;">
            <button onclick="window.print()"
                class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-4 sm:px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center font-semibold shadow-lg transform hover:scale-105 active:scale-95">
                <i class="fas fa-print mr-2"></i>Print Details
            </button>

            <a href="{{ route('student.dashboard', ['code' => $student->unique_code]) }}"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 sm:px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center font-semibold shadow-lg transform hover:scale-105 active:scale-95">
                <i class="fas fa-tachometer-alt mr-2"></i>Student Dashboard
            </a>

            <a href="{{ route('landing.index') }}"
                class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 sm:px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center font-semibold shadow-lg transform hover:scale-105 active:scale-95">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>

        <!-- Contact Information -->
        <div class="animate-slide-up bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-200"
            style="animation-delay: 0.4s;">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 text-center">
                <i class="fas fa-phone text-blue-600 mr-2"></i>Need Help?
            </h3>
            <div class="text-center space-y-2 text-sm sm:text-base">
                <div class="flex items-center justify-center space-x-2">
                    <i class="fab fa-whatsapp text-green-600"></i>
                    <span class="text-gray-600">WhatsApp:</span>
                    <strong class="text-gray-800">+62 812-3456-7890</strong>
                </div>
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-envelope text-blue-600"></i>
                    <span class="text-gray-600">Email:</span>
                    <strong class="text-gray-800">info@drivingschool.com</strong>
                </div>
                <div class="flex items-center justify-center space-x-2">
                    <i class="fas fa-clock text-purple-600"></i>
                    <span class="text-gray-600">Office Hours:</span>
                    <strong class="text-gray-800">Monday - Saturday, 08:00 - 17:00</strong>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Copy to clipboard function with enhanced feedback
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showCopyMessage('✅ Unique code copied to clipboard!');
            }, function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.opacity = '0';
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopyMessage('✅ Unique code copied to clipboard!');
            });
        }

        // Enhanced copy success message with animations
        function showCopyMessage(message) {
            const messageDiv = document.createElement('div');
            messageDiv.className =
                'fixed top-4 right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 sm:px-6 py-3 rounded-xl shadow-2xl z-50 transition-all transform translate-x-full';
            messageDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i><span class="font-semibold">${message}</span>`;
            document.body.appendChild(messageDiv);

            // Slide in animation
            setTimeout(() => {
                messageDiv.classList.remove('translate-x-full');
                messageDiv.classList.add('translate-x-0');
            }, 100);

            // Slide out animation
            setTimeout(() => {
                messageDiv.classList.remove('translate-x-0');
                messageDiv.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(messageDiv)) {
                        document.body.removeChild(messageDiv);
                    }
                }, 300);
            }, 2500);
        }

        // Page load animations
        document.addEventListener('DOMContentLoaded', function() {
            const uniqueCode = '{{ $student->unique_code }}';
            console.log('Student registered with unique code:', uniqueCode);

            // Add stagger animations to elements
            const animatedElements = document.querySelectorAll('.animate-slide-up');
            animatedElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Print styles enhancement
        window.addEventListener('beforeprint', function() {
            document.body.classList.add('printing');
        });

        window.addEventListener('afterprint', function() {
            document.body.classList.remove('printing');
        });

        // Add some interactive hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button, a[class*="bg-gradient"]');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>

</html>
