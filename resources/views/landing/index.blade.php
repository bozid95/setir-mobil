<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving School Registration</title>
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
                <div class="hidden md:flex space-x-6">
                    <a href="#home" class="text-gray-600 hover:text-blue-600 transition">Home</a>
                    <a href="#packages" class="text-gray-600 hover:text-blue-600 transition">Packages</a>
                    <a href="#track" class="text-gray-600 hover:text-blue-600 transition">Track Progress</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-5xl font-bold mb-6">Learn to Drive with Confidence</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Professional driving lessons with experienced instructors. Get
                your license with our comprehensive training programs.</p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="#packages"
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-graduation-cap mr-2"></i>View Packages
                </a>
                <a href="#track"
                    class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    <i class="fas fa-search mr-2"></i>Track Progress
                </a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Training Packages</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($packages as $package)
                    <div class="bg-white rounded-lg shadow-lg p-8 border hover:shadow-xl transition">
                        <div class="text-center">
                            <i class="fas fa-car text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $package->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $package->description }}</p>
                            <div class="text-3xl font-bold text-blue-600 mb-6">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500 mb-6">
                                Duration: {{ $package->duration_weeks }} weeks
                            </div>
                            <button
                                onclick="openRegistrationModal({{ $package->id }}, '{{ $package->name }}', {{ $package->price }})"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-user-plus mr-2"></i>Register Now
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Track Progress Section -->
    <section id="track" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Track Your Progress</h2>
                <form action="{{ route('student.track') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="tracking_code" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-code mr-2"></i>Enter Your Tracking Code
                        </label>
                        <input type="text" id="tracking_code" name="tracking_code" placeholder="e.g. DS2025ABC123"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-search mr-2"></i>Track Progress
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-gray-800">Register for Package</h3>
                        <button onclick="closeRegistrationModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">

                    <form action="{{ route('student.register') }}" method="POST">
                        @csrf
                        <input type="hidden" id="package_id" name="package_id">

                        <!-- Personal Information Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Personal Information</h4>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Enter your full name" value="{{ old('name') }}">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Gender <span class="text-red-500">*</span>
                                    </label>
                                    <select name="gender" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Date of Birth <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date_of_birth" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        value="{{ old('date_of_birth') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Place of Birth <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="place_of_birth" required placeholder="e.g. Jakarta"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('place_of_birth') }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Occupation/Job <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="occupation" required
                                    placeholder="e.g. Student, Teacher, Engineer"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('occupation') }}">
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Contact Information</h4>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" required placeholder="your.email@example.com"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('email') }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone_number" required placeholder="081234567890"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('phone_number') }}">
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="address" rows="3" required placeholder="Your complete address"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                <p class="text-sm text-blue-800">
                                    <strong>Note:</strong> All fields marked with <span class="text-red-500">*</span>
                                    are required to complete your registration.
                                </p>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-user-plus mr-2"></i>Complete Registration
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
                    <div>
                        <div class="font-semibold mb-1">Registration Error:</div>
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <script>
            function openRegistrationModal(packageId, packageName, packagePrice) {
                document.getElementById('package_id').value = packageId;
                document.getElementById('registrationModal').classList.remove('hidden');

                // Clear any previous validation messages
                clearValidationErrors();
            }

            function closeRegistrationModal() {
                document.getElementById('registrationModal').classList.add('hidden');
            }

            function clearValidationErrors() {
                const errorElements = document.querySelectorAll('.validation-error');
                errorElements.forEach(el => el.remove());

                const inputs = document.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-gray-300');
                });
            }

            // Form validation before submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const requiredFields = [{
                        name: 'name',
                        label: 'Full Name'
                    },
                    {
                        name: 'gender',
                        label: 'Gender'
                    },
                    {
                        name: 'place_of_birth',
                        label: 'Place of Birth'
                    },
                    {
                        name: 'date_of_birth',
                        label: 'Date of Birth'
                    },
                    {
                        name: 'occupation',
                        label: 'Occupation'
                    },
                    {
                        name: 'email',
                        label: 'Email'
                    },
                    {
                        name: 'phone_number',
                        label: 'Phone Number'
                    },
                    {
                        name: 'address',
                        label: 'Address'
                    }
                ];

                let hasErrors = false;
                clearValidationErrors();

                requiredFields.forEach(field => {
                    const input = document.querySelector(`[name="${field.name}"]`);
                    if (!input.value.trim()) {
                        showFieldError(input, `${field.label} is required`);
                        hasErrors = true;
                    }
                });

                // Email validation
                const emailInput = document.querySelector('[name="email"]');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailInput.value && !emailPattern.test(emailInput.value)) {
                    showFieldError(emailInput, 'Please enter a valid email address');
                    hasErrors = true;
                }

                // Date validation (must be before today)
                const dateInput = document.querySelector('[name="date_of_birth"]');
                if (dateInput.value) {
                    const birthDate = new Date(dateInput.value);
                    const today = new Date();
                    if (birthDate >= today) {
                        showFieldError(dateInput, 'Date of birth must be before today');
                        hasErrors = true;
                    }
                }

                if (hasErrors) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = document.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });

            function showFieldError(input, message) {
                input.classList.remove('border-gray-300');
                input.classList.add('border-red-500');

                const errorDiv = document.createElement('div');
                errorDiv.className = 'validation-error text-red-500 text-sm mt-1';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;

                input.parentNode.appendChild(errorDiv);
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Auto-hide success/error messages
            setTimeout(() => {
                const messages = document.querySelectorAll('.fixed.bottom-4.right-4');
                messages.forEach(msg => msg.style.display = 'none');
            }, 5000);

            // Auto-reopen modal if there are validation errors
            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    // Find the package_id from old input if available
                    const packageId = '{{ old('package_id') }}';
                    if (packageId) {
                        openRegistrationModal(packageId, '', 0);
                    }
                });
            @endif
        </script>
</body>

</html>
