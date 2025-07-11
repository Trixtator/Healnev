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

<section class="testimonials-section py-5 bg-white">
    <div class="container-fluid px-2">
        <div class="row mb-4 text-center">
            <h2 class="section-title">What Our Patients Say</h2>
        </div>

        <div class="scroll-wrapper">
            <div class="scroll-container d-flex">
                @forelse($testimonis as $testimoni)
                    <div class="card testimoni-card shadow-sm text-center border-0 rounded-4">
                        <div class="quote-icon text-primary fs-1 mb-3">
                            <i class="fas fa-quote-left"></i>
                        </div>

                        <img src="{{ $testimoni->user->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($testimoni->user->name) }}"
                             class="rounded-circle mx-auto mb-3" width="80" height="80" style="object-fit: cover;">

                        <p class="mb-3 text-muted px-3">
                            {{ $testimoni->message }}
                        </p>

                        <div class="mb-2">
                            @for ($i = 0; $i < $testimoni->rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                            @for ($i = $testimoni->rating; $i < 5; $i++)
                                <i class="fas fa-star text-muted"></i>
                            @endfor
                        </div>

                        <h6 class="fw-bold mb-0">{{ $testimoni->user->name }}</h6>
                    </div>
                @empty
                    <div class="text-center w-100">
                        <p class="text-muted">No testimonials yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<style>
     .scroll-wrapper {
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -ms-overflow-style: none;
    scrollbar-width: none;
    padding: 0 0.5rem; /* agar sisi kiri-kanan mepet tapi masih ada ruang sedikit */
}

.scroll-wrapper::-webkit-scrollbar {
    display: none;
}

.scroll-container {
    display: flex;
    gap: 20px;
    width: max-content;
    padding-bottom: 1rem;
}


    .testimoni-card {
        scroll-snap-align: start;
        width: 400px;
        flex-shrink: 0;
        background-color: #f9fafb;
        transition: all 0.3s ease-in-out;
        padding: 2rem 1rem;
        border-radius: 1rem;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }

    .testimoni-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    .testimoni-card .quote-icon i {
        transition: transform 0.3s ease;
    }

    .testimoni-card:hover .quote-icon i {
        transform: scale(1.1) rotate(-5deg);
    }

    .testimoni-card p {
        font-size: 0.95rem;
        color: #555;
    }

    .testimoni-card h6 {
        font-size: 1rem;
        color: #222;
    }

    @media (max-width: 768px) {
        .testimoni-card {
            width: 280px;
        }
    }
</style>





@auth
<div class="testimonial-container container mt-5 mb-5" style="max-width: 600px;">
    <h4 class="text-center mb-4"><strong>Write Your Testimonial</strong></h4>

    <form action="{{ route('testimoni.store') }}" method="POST">
        @csrf

        {{-- Star Rating --}}
        <div class="mb-3 text-center">
            <label class="form-label d-block"><strong>Your Rating</strong></label>
            <div id="star-container">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fa-star fa-regular fa-2x mx-1 star" data-value="{{ $i }}"></i>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" required>
        </div>

        {{-- Message --}}
        <div class="mb-3">
            <label for="message" class="form-label"><strong>Your Message</strong></label>
            <textarea name="message" id="message" rows="4" class="form-control"
                placeholder="Write your testimonial..." maxlength="100" required></textarea>
            <small class="text-muted d-block text-end mt-1"><span id="char-count">0</span>/100</small>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 25px;">Submit Testimonial</button>
        </div>
    </form>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
        timer: 3000
    });
</script>
@endif

{{-- Character counter --}}
<script>
    const textarea = document.getElementById('message');
    const charCount = document.getElementById('char-count');

    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });
</script>

{{-- Star Rating --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const ratingValue = index + 1;
                ratingInput.value = ratingValue;

                stars.forEach((s, i) => {
                    s.classList.remove('fa-solid');
                    s.classList.add('fa-regular');
                    if (i < ratingValue) {
                        s.classList.add('fa-solid');
                        s.classList.remove('fa-regular');
                    }
                });
            });
        });
    });
</script>

<style>
    .star {
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s ease;
    }

    .star.fa-solid {
        color: #00BFFF !important;
    }

    textarea.form-control {
        resize: vertical;
        padding: 12px;
        font-size: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .testimonial-container {
        padding-bottom: 80px;
    }
</style>
@else
<div class="container text-center mt-4">
    <p>Want to leave a testimonial? <a href="{{ route('login') }}">Login first</a>.</p>
</div>
@endauth





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