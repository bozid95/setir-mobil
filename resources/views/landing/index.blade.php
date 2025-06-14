<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Driving School - Learn to Drive with Confidence</title>
    <meta name="description"
        content="Professional driving lessons with experienced instructors. Get your license with our comprehensive training programs.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen font-sans">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-lg fixed w-full top-0 z-40 transition-all duration-300">
        <nav class="container mx-auto px-4 lg:px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-3 rounded-xl">
                        <i class="fas fa-car text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-800">Elite Driving School</h1>
                        <p class="text-xs text-gray-500 hidden sm:block">Professional Training Since 2020</p>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-xl text-gray-600"></i>
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="#home"
                        class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Home</a>
                    <a href="#about"
                        class="text-gray-600 hover:text-primary-600 transition-colors font-medium">About</a>
                    <a href="#packages"
                        class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Packages</a>
                    <a href="#track" class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Track
                        Progress</a>
                    <a href="#contact"
                        class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Contact</a>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="md:hidden mt-4 pb-4 border-t border-gray-200 hidden">
                <div class="space-y-3 pt-4">
                    <a href="#home"
                        class="block text-gray-600 hover:text-primary-600 transition-colors font-medium">Home</a>
                    <a href="#about"
                        class="block text-gray-600 hover:text-primary-600 transition-colors font-medium">About</a>
                    <a href="#packages"
                        class="block text-gray-600 hover:text-primary-600 transition-colors font-medium">Packages</a>
                    <a href="#track"
                        class="block text-gray-600 hover:text-primary-600 transition-colors font-medium">Track
                        Progress</a>
                    <a href="#contact"
                        class="block text-gray-600 hover:text-primary-600 transition-colors font-medium">Contact</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient text-white pt-24 pb-20 min-h-screen flex items-center">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center bg-white/20 glass-effect rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-star text-yellow-300 mr-2"></i>
                        <span class="text-sm font-medium">Rated #1 Driving School</span>
                    </div>

                    <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        Learn to Drive with
                        <span
                            class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">Confidence</span>
                    </h2>

                    <p class="text-lg lg:text-xl mb-8 text-white/90 max-w-xl">
                        Master the art of driving with our professional instructors. Get your license through our
                        comprehensive, safety-focused training programs designed for success.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#packages"
                            class="group bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold
                           hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-graduation-cap mr-2 group-hover:animate-bounce"></i>
                            View Training Packages
                        </a>
                        <a href="#track"
                            class="group border-2 border-white/50 text-white px-8 py-4 rounded-xl font-semibold
                           hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-search mr-2 group-hover:animate-pulse"></i>
                            Track Your Progress
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 text-center lg:text-left">
                        <div class="glass-effect rounded-xl p-4">
                            <div class="text-2xl font-bold">1000+</div>
                            <div class="text-sm text-white/80">Students Trained</div>
                        </div>
                        <div class="glass-effect rounded-xl p-4">
                            <div class="text-2xl font-bold">98%</div>
                            <div class="text-sm text-white/80">Pass Rate</div>
                        </div>
                        <div class="glass-effect rounded-xl p-4">
                            <div class="text-2xl font-bold">5★</div>
                            <div class="text-sm text-white/80">Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="floating-animation bg-white/10 glass-effect rounded-3xl p-8">
                            <i class="fas fa-car text-8xl text-white/80"></i>
                        </div>
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 bg-yellow-400 rounded-full p-4 animate-pulse">
                            <i class="fas fa-trophy text-2xl text-yellow-800"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-green-400 rounded-full p-4 animate-bounce">
                            <i class="fas fa-check text-2xl text-green-800"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="text-white/60 hover:text-white transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">Why Choose Elite Driving School?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We combine years of experience with modern teaching methods to provide the best driving education
                    experience.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div
                        class="bg-gradient-to-r from-primary-500 to-primary-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-graduate text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Expert Instructors</h3>
                    <p class="text-gray-600">Certified professionals with years of teaching experience</p>
                </div>

                <div class="text-center group">
                    <div
                        class="bg-gradient-to-r from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Safety First</h3>
                    <p class="text-gray-600">Modern vehicles with latest safety features and dual controls</p>
                </div>

                <div class="text-center group">
                    <div
                        class="bg-gradient-to-r from-purple-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Flexible Schedule</h3>
                    <p class="text-gray-600">Learn at your own pace with flexible timing options</p>
                </div>

                <div class="text-center group">
                    <div
                        class="bg-gradient-to-r from-orange-500 to-orange-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Digital Tracking</h3>
                    <p class="text-gray-600">Track your progress online with our digital platform</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-primary-100 text-primary-600 rounded-full px-4 py-2 mb-6">
                    <i class="fas fa-star mr-2"></i>
                    <span class="text-sm font-medium">Choose Your Perfect Package</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">Training Packages</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Comprehensive driving programs designed to fit your schedule and learning style.
                    All packages include theory, practical lessons, and exam preparation.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach ($packages as $index => $package)
                    <div
                        class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden {{ $index === 1 ? 'lg:scale-105 ring-2 ring-primary-500' : '' }}">
                        <!-- Popular Badge -->
                        @if ($index === 1)
                            <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white text-center py-2">
                                <span class="text-sm font-semibold">
                                    <i class="fas fa-crown mr-1"></i>Most Popular
                                </span>
                            </div>
                        @endif

                        <div class="p-8">
                            <!-- Package Icon -->
                            <div class="text-center mb-6">
                                <div
                                    class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r
                                    {{ $index === 0 ? 'from-green-400 to-green-500' : ($index === 1 ? 'from-primary-500 to-primary-600' : 'from-purple-500 to-purple-600') }}
                                    rounded-2xl flex items-center justify-center">
                                    <i
                                        class="fas {{ $index === 0 ? 'fa-car' : ($index === 1 ? 'fa-graduation-cap' : 'fa-trophy') }} text-3xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $package->name }}</h3>
                                <p class="text-gray-600 mb-6">{{ $package->description }}</p>
                            </div>

                            <!-- Price -->
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-gray-800 mb-2">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-500 bg-gray-50 rounded-lg px-3 py-2 inline-block">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Duration: {{ $package->duration_weeks }} weeks
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="space-y-3 mb-8">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Theory lessons included</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Practical driving sessions</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Exam preparation</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Digital progress tracking</span>
                                </div>
                                @if ($index >= 1)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>Priority scheduling</span>
                                    </div>
                                @endif
                                @if ($index === 2)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        <span>One-on-one sessions</span>
                                    </div>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            <button
                                onclick="openRegistrationModal({{ $package->id }}, '{{ $package->name }}', {{ $package->price }})"
                                class="w-full bg-gradient-to-r
                                {{ $index === 1 ? 'from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700' : 'from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black' }}
                                text-white py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fas fa-user-plus mr-2"></i>
                                {{ $index === 1 ? 'Get Started Now' : 'Register Now' }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-12">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">All Packages Include:</h3>
                    <div class="grid md:grid-cols-3 gap-6 text-center">
                        <div>
                            <i class="fas fa-book text-primary-500 text-2xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800">Theory Materials</h4>
                            <p class="text-gray-600 text-sm">Complete study guides and practice tests</p>
                        </div>
                        <div>
                            <i class="fas fa-car text-primary-500 text-2xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800">Modern Vehicles</h4>
                            <p class="text-gray-600 text-sm">Well-maintained cars with safety features</p>
                        </div>
                        <div>
                            <i class="fas fa-certificate text-primary-500 text-2xl mb-3"></i>
                            <h4 class="font-semibold text-gray-800">Certification</h4>
                            <p class="text-gray-600 text-sm">Official completion certificate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Track Progress Section -->
    <section id="track" class="py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center bg-primary-100 text-primary-600 rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-search mr-2"></i>
                        <span class="text-sm font-medium">Track Your Journey</span>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">Track Your Progress</h2>
                    <p class="text-lg text-gray-600">
                        Enter your unique tracking code to view your learning progress, schedule, and achievements.
                    </p>
                </div>

                <div
                    class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-xl border border-gray-100 p-8 lg:p-12">
                    <form id="trackProgressForm" action="{{ route('student.track') }}" method="POST"
                        class="space-y-6">
                        @csrf
                        <div class="space-y-4">
                            <label for="tracking_code" class="block text-gray-800 font-semibold text-lg mb-3">
                                <i class="fas fa-code text-primary-500 mr-2"></i>
                                Enter Your Tracking Code
                            </label>

                            <div class="relative">
                                <input type="text" id="tracking_code" name="tracking_code"
                                    placeholder="e.g. DS2025ABC123"
                                    class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl
                                              focus:ring-4 focus:ring-primary-100 focus:border-primary-500
                                              transition-all duration-300 bg-white shadow-sm"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <i class="fas fa-qrcode text-gray-400"></i>
                                </div>
                            </div>

                            <div class="text-sm text-gray-500 bg-blue-50 rounded-lg p-3">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                Your tracking code was provided after registration. Check your email or registration
                                confirmation.
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-primary-500 to-primary-600
                                       hover:from-primary-600 hover:to-primary-700 text-white py-4 px-8
                                       rounded-xl font-semibold text-lg transition-all duration-300
                                       transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-search mr-3"></i>
                            Track My Progress
                        </button>
                    </form>

                    <!-- Sample Codes for Demo -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-2xl">
                        <h4 class="font-semibold text-gray-800 mb-3">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                            Demo Codes (for testing):
                        </h4>
                        <div class="grid sm:grid-cols-2 gap-3 text-sm">
                            <div class="bg-white rounded-lg p-3 border">
                                <code class="text-primary-600 font-mono">DS2025D5BE89</code>
                                <span class="text-gray-500 ml-2">- Alice Student</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 border">
                                <code class="text-primary-600 font-mono">DS2025297D79</code>
                                <span class="text-gray-500 ml-2">- Bob Learner</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gradient-to-br from-gray-800 to-gray-900 text-white">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold mb-6">Get In Touch</h2>
                <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    Have questions about our programs? Ready to start your driving journey? Contact us today!
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div
                        class="bg-gradient-to-r from-primary-500 to-primary-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Call Us</h3>
                    <p class="text-gray-300 mb-2">Monday - Friday: 8AM - 8PM</p>
                    <p class="text-primary-400 font-semibold">+62 21 1234 5678</p>
                </div>

                <div class="text-center">
                    <div
                        class="bg-gradient-to-r from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Email Us</h3>
                    <p class="text-gray-300 mb-2">We reply within 24 hours</p>
                    <p class="text-green-400 font-semibold">info@elitedrivingschool.com</p>
                </div>

                <div class="text-center">
                    <div
                        class="bg-gradient-to-r from-purple-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Visit Us</h3>
                    <p class="text-gray-300 mb-2">Jakarta Training Center</p>
                    <p class="text-purple-400 font-semibold">Jl. Sudirman No. 123, Jakarta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-2 rounded-lg">
                            <i class="fas fa-car text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Elite Driving School</h3>
                            <p class="text-sm text-gray-400">Professional Training Since 2020</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Leading driving school in Jakarta, committed to providing safe, professional,
                        and comprehensive driving education for all skill levels.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="hover:text-primary-400 transition-colors">Home</a></li>
                        <li><a href="#about" class="hover:text-primary-400 transition-colors">About</a></li>
                        <li><a href="#packages" class="hover:text-primary-400 transition-colors">Packages</a></li>
                        <li><a href="#track" class="hover:text-primary-400 transition-colors">Track Progress</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-primary-400"></i>
                            +62 21 1234 5678
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary-400"></i>
                            info@elitedrivingschool.com
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-2 text-primary-400 mt-1"></i>
                            Jl. Sudirman No. 123, Jakarta
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    © 2025 Elite Driving School. All rights reserved. |
                    <a href="#" class="hover:text-primary-400 transition-colors">Privacy Policy</a> |
                    <a href="#" class="hover:text-primary-400 transition-colors">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

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
                            <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Personal Information
                            </h4>

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
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                            Female
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

            // Form validation before submit - Only for registration form
            document.querySelector('#registrationModal form').addEventListener('submit', function(e) {
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

            // Mobile menu toggle
            document.getElementById('mobileMenuBtn').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobileMenu');
                const icon = this.querySelector('i');

                mobileMenu.classList.toggle('hidden');

                if (mobileMenu.classList.contains('hidden')) {
                    icon.className = 'fas fa-bars text-xl text-gray-600';
                } else {
                    icon.className = 'fas fa-times text-xl text-gray-600';
                }
            });

            // Header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                if (window.scrollY > 100) {
                    header.classList.add('shadow-xl');
                } else {
                    header.classList.remove('shadow-xl');
                }
            });

            // Close mobile menu when clicking outside or on links
            document.addEventListener('click', function(e) {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');

                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.querySelector('i').className = 'fas fa-bars text-xl text-gray-600';
                }
            });

            // Close mobile menu when clicking on links
            document.querySelectorAll('#mobileMenu a').forEach(link => {
                link.addEventListener('click', function() {
                    const mobileMenu = document.getElementById('mobileMenu');
                    const mobileMenuBtn = document.getElementById('mobileMenuBtn');

                    mobileMenu.classList.add('hidden');
                    mobileMenuBtn.querySelector('i').className = 'fas fa-bars text-xl text-gray-600';
                });
            });

            // Track Progress form handler
            document.getElementById('trackProgressForm').addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const trackingCodeInput = this.querySelector('input[name="tracking_code"]');

                // Visual feedback
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Searching...';

                // Basic validation
                if (!trackingCodeInput.value.trim()) {
                    e.preventDefault();
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-search mr-3"></i>Track My Progress';

                    // Show error
                    trackingCodeInput.classList.add('border-red-500');
                    showTrackError('Please enter your tracking code.');
                    return;
                }

                if (trackingCodeInput.value.trim().length < 8) {
                    e.preventDefault();
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-search mr-3"></i>Track My Progress';

                    trackingCodeInput.classList.add('border-red-500');
                    showTrackError('Tracking code must be at least 8 characters.');
                    return;
                }

                // Clear any previous errors
                trackingCodeInput.classList.remove('border-red-500');
                hideTrackError();
            });

            function showTrackError(message) {
                hideTrackError(); // Remove any existing error

                const trackingCodeInput = document.querySelector('#trackProgressForm input[name="tracking_code"]');
                const errorDiv = document.createElement('div');
                errorDiv.id = 'track-error';
                errorDiv.className = 'text-red-500 text-sm mt-2';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;

                trackingCodeInput.parentNode.appendChild(errorDiv);
            }

            function hideTrackError() {
                const existingError = document.getElementById('track-error');
                if (existingError) {
                    existingError.remove();
                }
            }

            // Clear error when user starts typing
            document.querySelector('#trackProgressForm input[name="tracking_code"]').addEventListener('input', function() {
                this.classList.remove('border-red-500');
                hideTrackError();
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
