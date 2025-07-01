@extends('layouts.shared')

@section('content')
<!-- Hero Section - Ultra Modern Design -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 col-md-12">
                <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                    <!-- Animated Badge -->
                    <div class="hero-badge mb-4">
                        <span class="badge-icon">
                            <i class="fas fa-heart-pulse"></i>
                        </span>
                        <span class="badge-text">Trusted Medical Tourism Partner</span>
                    </div>

                    <!-- Animated Title -->
                    <h1 class="hero-title mb-4">
                        <span class="title-line" data-aos="fade-up" data-aos-delay="200">Transform Your</span>
                        <span class="title-line gradient-text" data-aos="fade-up" data-aos-delay="400">Health Journey</span>
                        <span class="title-line" data-aos="fade-up" data-aos-delay="600">in Paradise</span>
                    </h1>

                    <!-- Enhanced Description -->
                    <p class="hero-description mb-5" data-aos="fade-up" data-aos-delay="800">
                        Discover world-class healthcare combined with Indonesia's breathtaking beauty.
                        Our comprehensive medical tourism services ensure your comfort, safety, and
                        well-being throughout your transformative health journey.
                    </p>

                    <!-- Enhanced CTA Buttons -->
                    <div class="hero-actions mb-5" data-aos="fade-up" data-aos-delay="1000">
                        <a href="{{ route('packages') }}" class="btn btn-primary btn-lg btn-animated me-3">
                            <span class="btn-text">
                                <i class="fas fa-rocket me-2"></i>
                                Explore Packages
                            </span>
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-primary btn-lg btn-animated">
                            <span class="btn-text">
                                <i class="fas fa-play-circle me-2"></i>
                                Abouth
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-image-container" data-aos="fade-left" data-aos-duration="1000">
                    <div class="hero-image-wrapper">
                        <div class="image-frame">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop"
                                alt="Medical Tourism Excellence" class="hero-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MCU Packages Section - Minimalist -->
<section class="packages-section" id="paket-mcu">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-header" data-aos="fade-up">
                    <span class="section-subtitle">Our Services</span>
                    <h2 class="section-title">Medical Check-Up Packages</h2>
                    <p class="section-description">
                        Carefully curated packages combining comprehensive health assessments
                        with unforgettable Indonesian experiences
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($pakets as $index => $paket)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="package-card">
                    <div class="package-image">
                        @if($paket->gambar)
                        <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}">
                        @else
                        <div class="image-placeholder">
                            <i class="fas fa-medical-kit"></i>
                        </div>
                        @endif
                    </div>

                    <div class="package-content">
                        <h5 class="package-title">{{ $paket->nama_paket }}</h5>
                        @if($paket->rumahsakit)
                        <p class="package-hospital">
                            <i class="fas fa-hospital me-2"></i>
                            {{ $paket->rumahsakit->nama }}
                        </p>
                        @endif

                        <div class="package-price">
                            <span class="price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('paket.show', $paket->id) }}" class="btn btn-primary btn-package">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5>No Packages Available</h5>
                    <p>We're currently updating our service packages. Please check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($totalPakets > 6)
        <div class="row">
            <div class="col-12 text-center mt-5" data-aos="fade-up" data-aos-delay="600">
                <a href="{{ route('packages') }}" class="btn btn-outline-primary btn-lg">
                    View All {{ $totalPakets }} Packages
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Enhanced Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-header" data-aos="fade-up">
                    <span class="section-subtitle">Patient Stories</span>
                    <h2 class="section-title">What Our Patients Say</h2>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "HealthNav transformed my medical journey into an incredible experience.
                            The combination of world-class healthcare and beautiful Indonesian culture
                            made my recovery both effective and memorable."
                        </p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/team/rara.jpg" alt="Dara Amanda" class="author-avatar">
                        <div class="author-info">
                            <h6 class="author-name">Dara Amanda</h6>
                            <span class="author-location">Lampung, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "Exceptional service from start to finish! The medical team was incredibly
                            professional, and the tourism aspect allowed me to explore Indonesia's
                            beauty while focusing on my health."
                        </p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/team/iqbaal.jpg" alt="Iqbaal Ramadhan" class="author-avatar">
                        <div class="author-info">
                            <h6 class="author-name">Iqbaal Ramadhan</h6>
                            <span class="author-location">Sleman, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p class="testimonial-text">
                            "The perfect blend of medical excellence and cultural immersion.
                            HealthNav made my treatment journey comfortable, safe, and truly
                            enriching. Highly recommended!"
                        </p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/team/kikow.jpg" alt="Kikoww" class="author-avatar">
                        <div class="author-info">
                            <h6 class="author-name">Kikoww</h6>
                            <span class="author-location">Gresik, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Minimalist Share Experience Form -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="experience-form-section" data-aos="fade-up" data-aos-delay="400">
                    <div class="form-header text-center mb-4">
                        <h3 class="form-title">Share Your HealthNav Experience</h3>
                        <p class="form-subtitle">Your story could inspire others to take their health journey with confidence</p>
                    </div>

                    <div class="experience-form-card">
                        <form id="experienceForm" class="experience-form">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="name" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="location" placeholder="Your Location" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" id="photo" accept="image/*" placeholder="Photo (Optional)">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <textarea class="form-control" id="message" rows="4"
                                    placeholder="Share your experience with HealthNav..." required></textarea>
                                <div class="character-count">
                                    <span id="charCount">0</span>/300 characters
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Submit Your Story
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Minimalist Styles -->
<style>
    :root {
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --dark-color: #1a1a1a;
        --border-radius: 12px;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: var(--dark-color);
    }

    /* Hero Section */
    .hero-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.05), rgba(0, 86, 179, 0.02));
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 200px;
        height: 200px;
        top: 10%;
        right: 10%;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        bottom: 20%;
        left: 5%;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 100px;
        height: 100px;
        top: 50%;
        right: 30%;
        animation-delay: 4s;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        padding: 8px 20px;
        border-radius: 50px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 123, 255, 0.1);
    }

    .badge-icon {
        width: 24px;
        height: 24px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
    }

    .badge-text {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .hero-title {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description {
        font-size: 1.1rem;
        color: var(--secondary-color);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn {
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
    }

    /* Stats */
    .hero-stats {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 123, 255, 0.1);
    }

    .stat-item {
        text-align: center;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        color: white;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--secondary-color);
    }

    /* Hero Image */
    .hero-image-wrapper {
        position: relative;
    }

    .image-frame {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .hero-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    /* Services Section */
    .services-overview {
        padding: 80px 0;
        background: white;
    }

    .section-header {
        margin-bottom: 3rem;
    }

    .section-subtitle {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 10px 0 20px;
    }

    .section-description {
        font-size: 1.1rem;
        color: var(--secondary-color);
        max-width: 600px;
        margin: 0 auto;
    }

    .service-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .service-card:hover {
        transform: translateY(-5px);
    }

    .service-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-color);
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 1.5rem;
    }

    .service-card h5 {
        font-weight: 700;
        margin-bottom: 15px;
    }

    .service-card p {
        color: var(--secondary-color);
        line-height: 1.6;
    }

    /* Packages Section - Minimalist */
    .packages-section {
        padding: 80px 0;
        background: var(--light-color);
    }

    .package-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .package-card:hover {
        transform: translateY(-5px);
    }

    .package-image {
        height: 200px;
        overflow: hidden;
    }

    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--light-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
        font-size: 2rem;
    }

    .package-content {
        padding: 25px;
    }

    .package-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .package-hospital {
        color: var(--secondary-color);
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .package-price {
        margin-bottom: 20px;
    }

    .price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .btn-package {
        width: 100%;
        background: var(--primary-color);
        color: white;
        padding: 12px;
        border-radius: var(--border-radius);
        text-decoration: none;
        display: block;
        text-align: center;
        transition: var(--transition);
    }

    .btn-package:hover {
        background: var(--primary-dark);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--light-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: var(--secondary-color);
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: white;
    }

    .testimonial-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .testimonial-text {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 25px;
        font-style: italic;
        color: var(--dark-color);
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .author-name {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .author-location {
        color: var(--secondary-color);
        font-size: 0.9rem;
    }

    /* Experience Form - Ultra Minimalist */
    .experience-form-section {
        margin-top: 60px;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .form-subtitle {
        color: var(--secondary-color);
        margin-bottom: 40px;
    }

    .experience-form-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 40px;
        box-shadow: var(--shadow);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 12px 16px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        outline: none;
    }

    .character-count {
        text-align: right;
        font-size: 0.8rem;
        color: var(--secondary-color);
        margin-top: 5px;
    }

    /* Animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2rem;
            text-align: center;
        }

        .hero-description {
            text-align: center;
        }

        .hero-actions {
            text-align: center;
        }

        .btn {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .services-overview,
        .packages-section,
        .testimonials-section {
            padding: 60px 0;
        }

        .section-title {
            font-size: 2rem;
        }

        .experience-form-card {
            padding: 25px;
        }

        .form-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .service-card,
        .package-card,
        .testimonial-card {
            margin-bottom: 20px;
        }

        .experience-form-card {
            padding: 20px;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50
            });
        }

        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number[data-count]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-count'));
                        const duration = 2000;
                        const step = target / (duration / 16);
                        let current = 0;

                        const timer = setInterval(() => {
                            current += step;
                            if (current >= target) {
                                counter.textContent = target + '+';
                                clearInterval(timer);
                            } else {
                                counter.textContent = Math.floor(current) + '+';
                            }
                        }, 16);

                        observer.unobserve(counter);
                    }
                });
            }, {
                threshold: 0.5
            });

            counters.forEach(counter => observer.observe(counter));
        }

        // Experience Form Handler
        const experienceForm = document.getElementById('experienceForm');
        const messageTextarea = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        if (messageTextarea && charCount) {
            messageTextarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count;

                if (count > 300) {
                    this.value = this.value.substring(0, 300);
                    charCount.textContent = 300;
                }
            });
        }

        if (experienceForm) {
            experienceForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                submitBtn.disabled = true;

                // Simulate form submission
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    experienceForm.reset();
                    charCount.textContent = '0';

                    // Show success message
                    alert('Thank you for sharing your experience!');
                }, 1500);
            });
        }

        // Initialize counter animation
        animateCounters();

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>

<!-- AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection