<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
    <meta name="author" content="themefisher.com">

    <title>HealthNav</title>

    <!-- bootstrap.min css -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Icon Font Css -->
    <link rel="stylesheet" href=" {{asset('assets/plugins/icofont/icofont.min.css')}}">
    <!-- Slick Slider  CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick-carousel/slick/slick-theme.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Font Awesome CDN (v6.x) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body id="top">

    <!-- Header Start -->
    <header>
        <nav class="navbar navbar-expand-lg navigation nav-glass" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="main-logo" src="  {{ asset('assets/images/logo1.png') }}" alt="" class="img-fluid">
                </a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icofont-navigation-menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarmain">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link text-light {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light {{ (Route::is('packages') || Route::is('detail-paket')) ? 'active' : '' }}" href="{{ route('packages') }}">
                                packages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light {{ (Route::is('hospital') || Route::is('detail-hospital')) ? 'active' : '' }}" href="{{ route('hospital') }}">
                                Our Hospital
                            </a>
                        </li>

                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hello, {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item {{ Route::is('profile*') ? 'active' : '' }}" href="{{ route('profile') }}">My Profile</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-light {{ Route::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header End -->

    @yield('content')

    <!-- Enhanced Minimalist Footer -->
    <footer class="footer-minimalist">
        <!-- Decorative Wave -->
        <div class="footer-content">
            <div class="container">
                <!-- Main Footer Content -->
                <div class="row g-5 mb-5">
                    <!-- Brand Section -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <div class="brand-logo mb-4">
                                <img src="{{ asset('assets/images/logoo.png') }}" alt="HealthNav" class="footer-logo">
                            </div>
                            <p class="brand-description">
                                Your trusted partner in healthcare journey. We provide world-class medical tourism services with comfort, safety, and excellence.
                            </p>
                            <div class="social-links">
                                <a href="https://www.instagram.com/health.nav?igsh=MW15MzhidGR3aWJpdg%3D%3D&utm_source=qr"
                                    target="_blank" rel="noopener noreferrer" class="social-link instagram">
                                    <i class="icofont-instagram"></i>
                                </a>
                                <a href="https://wa.me/6281222071884"
                                    target="_blank" rel="noopener noreferrer" class="social-link whatsapp">
                                    <i class="icofont-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-links">
                            <h5 class="footer-title">Quick Links</h5>
                            <ul class="link-list">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('packages') }}">Packages</a></li>
                                <li><a href="{{ route('hospital') }}">Hospitals</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Services
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-links">
                            <h5 class="footer-title">Our Services</h5>
                            <ul class="link-list">
                                <li><a href="#">Medical Consultation</a></li>
                                <li><a href="#">Health Checkup</a></li>
                                <li><a href="#">Surgery Packages</a></li>
                                <li><a href="#">Recovery Programs</a></li>
                                <li><a href="#">Travel Assistance</a></li>
                            </ul>
                        </div>
                    </div> -->

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-contact">
                            <h5 class="footer-title">Get in Touch</h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="icofont-location-pin"></i>
                                    </div>
                                    <div class="contact-text">
                                        <p>Jl. Siliwangi No.63, Sleman, Daerah Istimewa Yogyakarta</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="icofont-phone"></i>
                                    </div>
                                    <div class="contact-text">
                                        <p>+62 812-2207-1884</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="icofont-email"></i>
                                    </div>
                                    <div class="contact-text">
                                        <p>info@healthnav.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">
                                &copy; {{ date('Y') }} <strong>HealthNav</strong>. All rights reserved.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-bottom-links">
                                <a href="#">Privacy Policy</a>
                                <a href="#">Terms of Service</a>
                                <a href="#">Support</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.easing.js') }}"></script>
    <script src="{{ asset('assets/plugins/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/shuffle/shuffle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/google-map/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/contact.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <!-- Botman Widget -->
    <script>
        var botmanWidget = {
            title: 'HealthNav Bot',
            aboutText: 'FAQ Bot',
            introMessage: "Hi there! 👋 Just type faq to see a list of frequently asked questions you can choose from. ",
        //     mainColor: '#0A76A4',
        // bubbleBackground: '#0A76A4',
        bubbleAvatarUrl: 'https://cdn-icons-png.flaticon.com/512/4712/4712035.png',
            
        };
    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

    <style>
        /* Botman Styles */
        .botman-container .message.user-bubble {
            justify-content: flex-end;
        }

        .botman-container .message.user-bubble .msg-content {
            background-color: #0084ff;
            color: white;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            left: auto !important;
            right: 0 !important;
            top: 100% !important;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
        }

        .dropdown-item button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0;
        }

        /* Enhanced Minimalist Footer Styles */
        .footer-minimalist {
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            color: #e2e8f0;
            margin-top: 0;
        }

        .footer-wave {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            height: 120px;
            overflow: hidden;
            z-index: 1;
        }

        .footer-wave svg {
            width: 100%;
            height: 100%;
        }

        .footer-content {
            position: relative;
            z-index: 2;
            padding: 140px 0 40px;
        }

        /* Brand Section */
        .footer-brand {
            max-width: 350px;
        }

        .footer-logo {
            max-height: 60px;
            width: auto;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .brand-description {
            font-size: 15px;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        /* Social Links */
        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-link:hover {
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .social-link.instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        }

        .social-link.whatsapp:hover {
            background: #25d366;
        }

        .social-link.youtube:hover {
            background: #ff0000;
        }

        /* Footer Titles */
        .footer-title {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            border-radius: 2px;
        }

        /* Links */
        .link-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .link-list li {
            margin-bottom: 12px;
        }

        .link-list a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0;
        }

        .link-list a:hover {
            color: #ffffff;
            padding-left: 8px;
        }

        .link-list a::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 2px;
            background: #3b82f6;
            transition: width 0.3s ease;
        }

        .link-list a:hover::before {
            width: 6px;
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .contact-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 10px;
            color: #3b82f6;
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .contact-text p {
            margin: 0;
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Footer Bottom */
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            margin-top: 50px;
        }

        .copyright-text {
            margin: 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .footer-bottom-links {
            display: flex;
            justify-content: flex-end;
            gap: 25px;
        }

        .footer-bottom-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #ffffff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-content {
                padding: 120px 0 30px;
            }

            .footer-brand {
                max-width: 100%;
                text-align: center;
                margin-bottom: 40px;
            }

            .social-links {
                justify-content: center;
            }

            .footer-title {
                text-align: center;
                font-size: 16px;
            }

            .link-list {
                text-align: center;
            }

            .contact-info {
                align-items: center;
            }

            .contact-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .footer-bottom-links {
                justify-content: center;
                margin-top: 20px;
                gap: 15px;
            }

            .copyright-text {
                text-align: center;
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .footer-wave {
                height: 80px;
            }

            .footer-content {
                padding: 100px 0 25px;
            }

            .social-link {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .footer-bottom-links {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-brand,
        .footer-links,
        .footer-contact {
            animation: fadeInUp 0.6s ease-out;
        }

        .footer-links {
            animation-delay: 0.1s;
        }

        .footer-contact {
            animation-delay: 0.2s;
        }
    </style>

    @stack('scripts')
</body>

</html>