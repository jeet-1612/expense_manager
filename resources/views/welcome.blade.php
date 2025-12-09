<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Track and manage your expenses effortlessly with Expense Manager - The smart way to control your finances.">
    
    <title>Expense Manager - Smart Financial Tracking</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .stat-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .hero-section {
            background: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)), 
                        url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-['Figtree']">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-chart-pie text-2xl text-purple-600 mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">Expense<span class="text-purple-600">Manager</span></span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-purple-600 font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 font-medium">How It Works</a>
                    <a href="#pricing" class="text-gray-600 hover:text-purple-600 font-medium">Pricing</a>
                    <a href="#contact" class="text-gray-600 hover:text-purple-600 font-medium">Contact</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                            Dashboard <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                            Get Started Free
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-purple-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="#features" class="block px-3 py-2 text-gray-600 hover:text-purple-600 hover:bg-gray-50 rounded-md">Features</a>
                <a href="#how-it-works" class="block px-3 py-2 text-gray-600 hover:text-purple-600 hover:bg-gray-50 rounded-md">How It Works</a>
                <a href="#pricing" class="block px-3 py-2 text-gray-600 hover:text-purple-600 hover:bg-gray-50 rounded-md">Pricing</a>
                <a href="#contact" class="block px-3 py-2 text-gray-600 hover:text-purple-600 hover:bg-gray-50 rounded-md">Contact</a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 btn-primary text-white rounded-md text-center">
                        Dashboard
                    </a>
                @else
                    <div class="pt-4 border-t">
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-600 hover:text-purple-600 hover:bg-gray-50 rounded-md">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 mt-2 btn-primary text-white rounded-md text-center">
                            Get Started Free
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section pt-32 pb-20 md:pt-40 md:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Take Control of Your
                    <span class="stat-number">Finances</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-10 max-w-3xl mx-auto">
                    Track expenses, set budgets, and achieve financial goals with our intuitive expense management platform.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary text-white px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                            Go to Dashboard <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                            Start Free Trial <i class="fas fa-rocket ml-3"></i>
                        </a>
                        <a href="#features" class="btn-secondary px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center justify-center">
                            <i class="fas fa-play-circle mr-3"></i> Watch Demo
                        </a>
                    @endauth
                </div>
                
                <div class="mt-12 flex justify-center space-x-8 text-gray-600">
                    <div class="text-center">
                        <div class="text-3xl font-bold stat-number">10K+</div>
                        <div class="text-sm">Happy Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold stat-number">₹50M+</div>
                        <div class="text-sm">Tracked</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold stat-number">99%</div>
                        <div class="text-sm">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Everything you need to manage your finances effectively
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expense Tracking</h3>
                    <p class="text-gray-600">
                        Track all your expenses in one place with detailed categories and tags. Get insights into your spending patterns.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Budget Planning</h3>
                    <p class="text-gray-600">
                        Set monthly budgets for different categories and get alerts when you're approaching your limits.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-file-invoice-dollar text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Reports & Analytics</h3>
                    <p class="text-gray-600">
                        Generate detailed reports and visualize your financial data with interactive charts and graphs.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile Friendly</h3>
                    <p class="text-gray-600">
                        Access your expense data anytime, anywhere with our responsive mobile-friendly interface.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Secure & Private</h3>
                    <p class="text-gray-600">
                        Your financial data is encrypted and secure. We never share your personal information.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white rounded-xl shadow-lg p-8 feature-card">
                    <div class="w-16 h-16 gradient-bg rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-sync-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Auto Sync</h3>
                    <p class="text-gray-600">
                        Automatically sync your data across all devices. Never lose your financial information.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Get started in just three simple steps
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto">
                            <span class="text-white text-2xl font-bold">1</span>
                        </div>
                        <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gradient-to-r from-purple-400 to-transparent"></div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sign Up Free</h3>
                    <p class="text-gray-600">
                        Create your account in less than 2 minutes. No credit card required for the free trial.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto">
                            <span class="text-white text-2xl font-bold">2</span>
                        </div>
                        <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gradient-to-r from-purple-400 to-transparent"></div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Add Expenses</h3>
                    <p class="text-gray-600">
                        Start adding your expenses manually or import from your bank statements.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto">
                            <span class="text-white text-2xl font-bold">3</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analyze & Save</h3>
                    <p class="text-gray-600">
                        Use our insights to identify saving opportunities and reach your financial goals faster.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Choose the plan that's right for you
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Free</h3>
                        <div class="flex items-center justify-center">
                            <span class="text-4xl font-bold stat-number">₹0</span>
                            <span class="text-gray-500 ml-2">/month</span>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Up to 50 expenses/month</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Basic categories</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Monthly reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times text-gray-300 mr-3"></i>
                            <span class="text-gray-400">Advanced analytics</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times text-gray-300 mr-3"></i>
                            <span class="text-gray-400">Priority support</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('register') }}" class="btn-secondary w-full py-3 rounded-lg font-semibold">
                        Get Started Free
                    </a>
                </div>
                
                <!-- Pro Plan -->
                <div class="bg-white rounded-xl shadow-xl p-8 text-center relative transform scale-105">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                            MOST POPULAR
                        </span>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Pro</h3>
                        <div class="flex items-center justify-center">
                            <span class="text-4xl font-bold stat-number">₹299</span>
                            <span class="text-gray-500 ml-2">/month</span>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Unlimited expenses</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Custom categories</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Advanced reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Budget planning</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Priority support</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('register') }}" class="btn-primary w-full py-3 rounded-lg font-semibold text-white">
                        Start Free Trial
                    </a>
                </div>
                
                <!-- Business Plan -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Business</h3>
                        <div class="flex items-center justify-center">
                            <span class="text-4xl font-bold stat-number">₹999</span>
                            <span class="text-gray-500 ml-2">/month</span>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Everything in Pro</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Multi-user access</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Custom branding</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>API access</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Dedicated support</span>
                        </li>
                    </ul>
                    
                    <a href="#contact" class="btn-secondary w-full py-3 rounded-lg font-semibold">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Ready to Take Control of Your Finances?
            </h2>
            <p class="text-xl text-purple-100 mb-10">
                Join thousands of users who have saved money and achieved their financial goals.
            </p>
            
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center hover:bg-gray-100 transition">
                    Go to Dashboard <i class="fas fa-arrow-right ml-3"></i>
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg inline-flex items-center hover:bg-gray-100 transition">
                    Start Your Free Trial <i class="fas fa-rocket ml-3"></i>
                </a>
            @endauth
            
            <p class="text-purple-200 mt-6 text-sm">
                No credit card required • 14-day free trial • Cancel anytime
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-6">
                        <i class="fas fa-chart-pie text-2xl text-purple-400 mr-2"></i>
                        <span class="text-xl font-bold">Expense<span class="text-purple-400">Manager</span></span>
                    </div>
                    <p class="text-gray-400">
                        The smart way to track and manage your expenses. Achieve your financial goals faster.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 hover:text-white">Features</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Documentation</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Press</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6">Contact</h4>
                    <ul class="space-y-3">
                        <li class="text-gray-400">
                            <i class="fas fa-envelope mr-2"></i>
                            support@expensemanager.com
                        </li>
                        <li class="text-gray-400">
                            <i class="fas fa-phone mr-2"></i>
                            +91 12345 67890
                        </li>
                        <li class="text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Mumbai, India
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Expense Manager. All rights reserved.</p>
                <p class="mt-2 text-sm">
                    <a href="#" class="hover:text-white">Privacy Policy</a> • 
                    <a href="#" class="hover:text-white">Terms of Service</a> • 
                    <a href="#" class="hover:text-white">Cookie Policy</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>