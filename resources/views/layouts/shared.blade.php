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

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    
</head>

<body id="top">

    <!--##########################################################################################################################-->

    <!-- Header Start -->
    <header>
        <!-- <div class="header-top-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <ul class="top-bar-info list-inline-item pl-0 mb-0">
                            <li class="list-inline-item"><a href="mailto:support@care.com"><i class="icofont-support-faq mr-2"></i>HealthNav@care.com</a></li>
                            <li class="list-inline-item"><i class="icofont-location-pin mr-2"></i>Yogyakarta, Indonesia </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-lg-right top-right-bar mt-2 mt-lg-0">
                            <a href="tel:+23-345-67890">
                                <span>Call Now : </span>
                                <span class="">+62 877-3903-5397</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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

        {{-- Tautan ke Halaman Home --}}
        <li class="nav-item">
            <a class="nav-link text-light {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                Home
            </a>
        </li>

        {{-- Tautan ke Halaman About --}}
        <li class="nav-item">
            <a class="nav-link text-light {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                About
            </a>
        </li>
        
        {{-- Tautan ke Halaman Contact --}}
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

        {{-- Tautan ke Halaman Our Hospital --}}
        {{-- Logika ini akan aktif baik di halaman utama rumah sakit maupun di halaman detailnya --}}
        <li class="nav-item">
            <a class="nav-link text-light {{ (Route::is('hospital') || Route::is('detail-hospital')) ? 'active' : '' }}" href="{{ route('hospital') }}">
                Our Hospital
            </a>
        </li>

        {{-- Logika untuk Pengguna yang Sudah Login atau Belum --}}
        @auth
            {{-- Jika sudah login, tampilkan dropdown menu --}}
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
            {{-- Jika belum login, tampilkan link untuk Login --}}
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

    <!--##########################################################################################################################-->

    @yield('content')

    <!--##########################################################################################################################-->

    <!-- footer Start -->
   <footer class="footer-modern">
    {{-- Elemen dekoratif untuk bagian atas footer --}}
    <div class="footer-shape-top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="none">
            <path d="M1440 21.2105V120H0V21.2105C506.667 6.42105 1104 -16.9474 1440 21.2105Z" fill="#002F4B"/>
        </svg>
    </div>

    <div class="container">
        <div class="row">

            {{-- Kolom 1: Tentang Perusahaan & Logo --}}
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                <div class="footer-widget">
                    <img src="{{ asset('assets/images/logoo.png') }}" alt="HealthNav Logo" class="footer-logo mb-4">
                    <p>We are your trusted partner in your healthcare journey, providing safe, comfortable, and high-quality international medical services.</p>
                    
                    <h5 class="social-title mt-4">Follow Us</h5>
                    <ul class="footer-socials list-inline">
                        <li class="list-inline-item">
                           <a href="https://www.instagram.com/health.nav?igsh=MW15MzhidGR3aWJpdg%3D%3D&utm_source=qr" 
                                aria-label="Instagram" 
                                target="_blank" 
                                rel="noopener noreferrer">
                                <i class="icofont-instagram"></i>
                            </a>

                        </li>
                        <li class="list-inline-item">
                            <a href="https://wa.me/6283140728424" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                aria-label="WhatsApp">
                                <i class="icofont-whatsapp"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" aria-label="YouTube"><i class="icofont-youtube-play"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Kolom 2: Link Navigasi Cepat --}}
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                <div class="footer-widget">
                    <h4 class="widget-title">Quick Links</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}"><i class="icofont-simple-right"></i> Home</a></li>
                        <li><a href="{{ route('about') }}"><i class="icofont-simple-right"></i> About Us</a></li>
                        <li><a href="{{ route('paket.index') }}"><i class="icofont-simple-right"></i> Our Packages</a></li>
                        <li><a href="{{ route('hospital') }}"><i class="icofont-simple-right"></i> Our Hospitals</a></li>
                        <li><a href="{{ route('contact') }}"><i class="icofont-simple-right"></i> Contact</a></li>
                    </ul>
                </div>
            </div>

            {{-- Kolom 3: Informasi Kontak --}}
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h4 class="widget-title">Contact Info</h4>
                    <ul class="list-unstyled footer-contact-info">
                        <li>
                            <i class="icofont-location-pin"></i>
                            <p>Jl. Laksda Adisucipto No.32-34, Demangan, Gondokusuman, Yogyakarta</p>
                        </li>
                        <li>
                            <i class="icofont-ui-touch-phone"></i>
                            <p>++62 831-4072-8424</p>
                        </li>
                        <li>
                            <i class="icofont-email"></i>
                            <p>info@healthnav.com</p>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    {{-- Bagian Copyright di paling bawah --}}
    <div class="footer-bottom">
        <div class="container text-center">
            <p class="copyright-text mb-0">&copy; {{ date('Y') }} HealthNav. All Rights Reserved.</p>
        </div>
    </div>
</footer>

    <!-- footer End -->


    <!--##########################################################################################################################-->

    <!-- 
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.js') }}
    "></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.easing.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('assets/plugins/slick-carousel/slick/slick.min.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ asset('assets/plugins/counterup/jquery.waypoints.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/shuffle/shuffle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!-- Google Map -->
    <script src="{{ asset('assets/plugins/google-map/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/contact.js') }}"></script>
    <!-- Bootstrap JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')


    <!-- botman -->
    <script>
    var botmanWidget = {
        aboutText: 'FAQ Bot',
        introMessage: "👋 Hai! Ketik 'faq' untuk melihat pertanyaan umum."
    };
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
<style>
        /* Target container pesan yang sudah kita beri "tanda" user-bubble */
        .botman-container .message.user-bubble {
            /* Mendorong seluruh baris pesan ke ujung kanan */
            justify-content: flex-end;
        }

        /* Target bubble chat di dalam container yang sudah ditandai */
        .botman-container .message.user-bubble .msg-content {
            /* Mengubah warna latar belakangnya agar seperti chat dari user */
            /* Anda bisa mengganti kode warna #0084ff ini sesuai selera */
            background-color: #0084ff;
            color: white;
        }
    </style>

    <style>
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

        .footer-modern {
    position: relative;
    background-color: #002F4B; /* Warna tema Anda */
    color: rgba(255, 255, 255, 0.7); /* Warna teks putih transparan */
    padding: 150px 0 0 0; /* Padding atas lebih besar untuk memberi ruang bagi shape */
}

/* Elemen SVG dekoratif di bagian atas */
.footer-shape-top {
    position: absolute;
    top: -1px; /* Sedikit overlap untuk menghilangkan celah */
    left: 0;
    width: 100%;
    z-index: 1;
}
.footer-shape-top svg {
    width: 100%;
    height: auto;
}

/* Logo di footer */
.footer-logo {
    max-width: 250px;
    filter: brightness(0) invert(1); /* Membuat logo PNG hitam menjadi putih */
}

/* Judul setiap widget di footer */
.widget-title {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

/* Garis bawah dekoratif untuk judul widget */
.widget-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 2px;
    background-color: #e12454; /* Warna aksen pink dari tema Anda */
}

/* Link navigasi di footer */
.footer-links li a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    padding: 5px 0;
    display: inline-block;
    transition: all 0.3s ease;
}
.footer-links li a:hover {
    color: #ffffff;
    transform: translateX(5px);
}
.footer-links li i {
    margin-right: 8px;
    font-size: 12px;
}

/* Informasi kontak di footer */
.footer-contact-info li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}
.footer-contact-info i {
    font-size: 20px;
    color: #e12454; /* Warna aksen pink */
    margin-right: 15px;
    margin-top: 5px;
}
.footer-contact-info p {
    margin-bottom: 0;
}

/* Ikon sosial media */
.social-title {
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
}
.footer-socials li a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    font-size: 18px;
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
}
.footer-socials li a:hover {
    background-color: #e12454; /* Warna aksen pink */
    transform: translateY(-3px);
}

/* Bagian copyright */
.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 25px 0;
    margin-top: 50px;
}
.copyright-text {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
}
    </style>

    <!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/684f0354b28b01190c4fd87f/1itqaa0mr';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->
@stack('scripts') 
</body>

</html>