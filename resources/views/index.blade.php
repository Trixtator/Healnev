@extends('layouts.shared')

@section('content')
<!-- Slider Start -->
<section class="banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-xl-7">
                <div class="block">
                    <div class="divider mb-3"></div>
                    <span class="text-uppercase text-sm letter-spacing" style="color: black;">Medical Tourism</span>
                    <h1 class="mb-3 mt-3" style="color: #26355D;">HealthNav</h1>
                    <p class="mb-4 pr-5" style="color: black;">Medical tourism is a person's trip abroad for the purpose
                        of
                        receiving health care, including general check-ups, treatment, and rehabilitation. In the health
                        industry, patients will be more likely to seek safe, comfortable, and quality services.</p>
                    <a href="/about" class="btn btn-danger">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            {{-- Kolom Kiri: Teks dan Informasi --}}
            <div class="col-lg-6 col-md-12">
                <div class="hero-content">
                    {{-- Ikon yang Anda minta --}}
                    <div class="hero-icons">
                        <div class="icon-circle">
                            <i class="icofont-hospital"></i>
                        </div>
                        <div class="icon-circle">
                            <i class="icofont-airplane-alt"></i>
                        </div>
                    </div>

                    {{-- Konten Teks --}}
                    <!-- <h2 class="hero-subheading">MEDICAL TOURISM</h2> -->
                    <h1 class="hero-title">MEDICAL TOURISM</h1>
                    <p class="hero-text">
                        Our world-class healthcare facilities are designed to offer outstanding services for international patients. From the moment you arrive, we ensure a smooth and comfortable journey — with personalized treatments, professional care, and warm hospitality every step of the way.

Whether you’re here for advanced medical procedures, routine check-ups, or long-term care, we provide a welcoming environment that combines expert healthcare with convenience and compassion. Your comfort and well-being are our priority — because every patient deserves exceptional care, no matter where they come from.
                    </p>
                    <!-- <a href="{{ route('about') }}" class="btn btn-main-2 btn-round-full">Learn More <i class="icofont-simple-right ml-2"></i></a> -->
                </div>
            </div>

            {{-- Kolom Kanan: Gambar Ilustrasi/Hero --}}
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-image">
                    {{-- Ganti URL gambar ini dengan gambar pilihan Anda --}}
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop" 
                         alt="Doctor showing information to patient" class="img-fluid rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Informasi Paket MCU -->
<style>
    /* Style utama untuk setiap kartu paket */
    .paket-card {
        display: block;
        background-color: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 15px;
        overflow: hidden;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: 100%; /* Penting: Membuat semua kartu dalam satu baris sama tinggi */
    }

    /* Efek saat mouse diarahkan ke kartu */
    .paket-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    }

    /* Kontainer untuk gambar, agar bisa menampung overlay */
    .paket-card .card-image {
        position: relative; 
    }

    /* Style untuk gambar di dalam kartu */
    .paket-card .card-image img {
        width: 100%;
        height: 190px; /* Kunci: Ukuran tinggi gambar yang seragam */
        object-fit: cover; /* Kunci: Agar gambar pas tanpa distorsi */
    }
    
    /* Style untuk placeholder jika gambar tidak ada */
    .image-placeholder {
        width: 100%;
        height: 190px; /* TINGGI HARUS SAMA DENGAN TINGGI GAMBAR */
        background-color: #e9ecef;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #adb5bd;
    }

    .image-placeholder .icofont-image {
        font-size: 50px;
    }

    /* Style untuk label/tag di atas gambar */
    .paket-card .card-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 86, 179, 0.7);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    /* Bagian konten teks di bawah gambar */
    .paket-card .card-body {
        padding: 20px 25px;
    }

    /* Style untuk judul paket */
    .paket-card .card-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 4px;
        /* Trik untuk membatasi judul menjadi 2 baris */
        /* display: -webkit-box; */
        /* -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px; Kira-kira 2x tinggi baris tulisan */
    }

    /* Style untuk nama provider/rumah sakit */
    .paket-card .card-provider {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    /* Style untuk harga */
    .paket-card .card-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: #d9534f;
    }
</style>

<section class="features mt-5" id="paket-mcu">
    <div class="container">
        {{-- Bagian Judul Section --}}
        <div class="row">
            <div class="col-12 text-center mb-5">
    <h2 style="color: #26355D; font-size: 3em; font-weight: bold;">
        MCU Package Information
    </h2>
    <p style="font-size: 1.2em; color: #555;">Choose a package that fits your health and travel needs.</p>
</div>

        </div>

        {{-- Grid untuk menampilkan 8 Kartu Paket --}}
        <div class="row">
            {{-- Loop ini sekarang hanya akan berjalan maksimal 8 kali --}}
            @forelse($pakets as $paket)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    {{-- Di sini kita asumsikan nama route detail paket Anda adalah 'paket.show' --}}
                    <a href="{{ route('paket.show', $paket->id) }}" class="paket-card w-100">

                        <div class="card-image">
                            @if($paket->gambar)
                                <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}">
                            @else
                                <div class="image-placeholder">
                                    <i class="icofont-image"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="mb-auto">
                                <h5 class="card-title">{{ $paket->nama_paket }}</h5>

                                @if($paket->rumahsakit)
                                    <p class="card-provider">{{ $paket->rumahsakit->nama }}</p>
                                @else
                                    <p class="card-provider">&nbsp;</p>
                                @endif
                            </div>

                            <div class="card-price">
                                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Saat ini belum ada paket layanan yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- ======================================================= --}}
        {{-- == BAGIAN BARU: Tombol "View More" == --}}
        {{-- ======================================================= --}}
        {{-- Tombol ini hanya akan muncul jika total paket lebih dari 8 --}}
        @if($totalPakets > 8)
            <div class="row">
                <div class="col-12 text-center mt-4">
                    {{-- Tombol ini mengarah ke halaman 'packages' Anda yang berpaginasi --}}
                    <a href="{{ route('packages') }}" class="btn btn-main-2 btn-round-full">View More Packages</a>
                </div>
            </div>
        @endif

    </div>
</section>

<!-- <section class="features mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 style="color: #26355D; font-size: 3em; font-weight: bold; position: relative; display: inline-block; padding-bottom: 0.5em;">
                    MCU Package Information
                    <span style="display: block; height: 5px; width: 100px; background-color: #0056b3; margin: 0.5em auto 0; border-radius: 5px;"></span>
                </h2>
                <p style="font-size: 1.2em; color: #555;">Choose a package that suits your health and travel needs</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-item text-center p-4" style="background-color: #f8d7da; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; height: 100%;">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-heartbeat" style="font-size: 48px; color: #dc3545;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #ffffff; font-weight: bold;">Basic MCU</h4>
                    <p class="mb-4 custom-scrollbar" style="color: #ffffff; height: 120px; overflow-y: auto; padding: 0 10px;">The Basic Medical Check-Up Package includes essential health assessments, such as measuring blood pressure and conducting basic blood tests. It also includes a general physical examination to evaluate your health.</p>
                    <div style="margin: 20px 0; padding: 15px; background-color: rgba(255,255,255,0.3); border-radius: 15px;">
                        <h5 style="color: #721c24; font-weight: bold;">Excursions Included:</h5>
                        <ul style="color: #721c24; text-align: left; padding-left: 20px;">
                            <li>Bukit Paralayang</li>
                            <li>Malioboro</li>
                        </ul>
                    </div>
                    <a href="{{ url('about#basic-mcu') }}" class="btn btn-danger" style="border-radius: 50px; padding: 10px 30px; font-weight: bold; transition: all 0.3s ease;">Harga: Rp 500.000</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-item text-center p-4" style="background-color: #d4edda; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; height: 100%;">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-stethoscope" style="font-size: 48px; color: #28a745;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #ffffff; font-weight: bold;">Standard MCU</h4>
                    <p class="mb-4 custom-scrollbar" style="color: #ffffff; height: 120px; overflow-y: auto; padding: 0 10px;">The Standard Medical Check-Up package includes all the assessments in the Basic package, plus additional comprehensive tests. These include measuring cholesterol levels and conducting an EKG. More detailed blood tests are also included.</p>
                    <div style="margin: 20px 0; padding: 15px; background-color: rgba(255,255,255,0.3); border-radius: 15px;">
                        <h5 style="color: #155724; font-weight: bold;">Excursions Included:</h5>
                        <ul style="color: #155724; text-align: left; padding-left: 20px;">
                            <li>Bukit Paralayang</li>
                            <li>Malioboro</li>
                            <li>Candi Prambanan</li>
                        </ul>
                    </div>
                    <a href="{{ url('about#standard-mcu') }}" class="btn btn-success" style="border-radius: 50px; padding: 10px 30px; font-weight: bold; transition: all 0.3s ease;">Harga: Rp 1.000.000</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-item text-center p-4" style="background-color: #cce5ff; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; height: 100%;">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-user-md" style="font-size: 48px; color: #007bff;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #ffffff; font-weight: bold;">Premium MCU</h4>
                    <p class="mb-4 custom-scrollbar" style="color: #ffffff; height: 120px; overflow-y: auto; padding: 0 10px;">The Premium Medical Check-Up package offers the most comprehensive health assessment, including all tests from the Basic and Standard packages, as well as advanced imaging tests such as MRI, CT scan, and detailed consultations with specialists.</p>
                    <div style="margin: 20px 0; padding: 15px; background-color: rgba(255,255,255,0.3); border-radius: 15px;">
                        <h5 style="color: #004085; font-weight: bold;">Excursions Included:</h5>
                        <ul style="color: #004085; text-align: left; padding-left: 20px;">
                            <li>Bukit Paralayang</li>
                            <li>Malioboro</li>
                            <li>Candi Prambanan</li>
                            <li>Candi Borobudur</li>
                            <li>Pantai Parangtritis</li>
                        </ul>
                    </div>
                    <a href="{{ url('about#premium-mcu') }}" class="btn btn-primary" style="border-radius: 50px; padding: 10px 30px; font-weight: bold; transition: all 0.3s ease;">Harga: Rp 2.500.000</a>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- End Informasi Paket MCU -->

<!-- Pendaftaran MCU Section -->
<!-- <section id="pendaftaran-mcu" class="section cta-page" style="padding: 60px 0; background-color: #f9f9f9;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="cta-content" style="padding: 20px; background-color: #6F8BA4;">
                    <h2 class="title-color"
                        style="font-family: 'Arial', sans-serif; color: #333; font-size: 36px; line-height: 1.4; margin-bottom: 20px;">
                        Register for <br>Medical Check-Up for Tourists
                    </h2>
                    <p class="lead" style="color: #ffff; font-size: 18px; margin-bottom: 30px;">
                        Take care of your health while traveling in Indonesia by doing a medical check-up. Fill out the
                        following form to register.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-wrapper"
                    style="padding: 30px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background: linear-gradient(to right, #f0f8ff, #e0f7fa);">
                    <div class="form-header"
                        style="background-color: #003366; color: #fff; padding: 10px 20px; border-radius: 15px 15px 0 0; font-size: 18px;">
                        Registration Form
                    </div>
                    <form id="form-pendaftaran-mcu" class="appoinment-form" method="post"
                        action="{{ route('submit-registration') }}" style="padding: 20px;">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Full name</label>
                                    <input name="name" id="name" type="text" class="form-control"
                                        placeholder="Full name" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input name="phone" id="phone" type="tel" class="form-control"
                                        placeholder="Phone number" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" type="email" class="form-control" placeholder="Email"
                                        required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="birthdate">Date of birth</label>
                                    <input name="birthdate" id="birthdate" type="date" class="form-control"
                                        placeholder="Date of birth" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="passport">Passport number</label>
                                    <input name="passport" id="passport" type="text" class="form-control"
                                        placeholder="Passport number" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">Address in Indonesia</label>
                                    <input name="address" id="address" type="text" class="form-control"
                                        placeholder="Address in Indonesia" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="reservation_date">Reservation Date</label>
                                    <input name="reservation_date" id="reservation_date" type="date"
                                        class="form-control" placeholder="Reservation Date" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="time">Select Time</label>
                                    <select class="form-control" name="time" id="time" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                        <option value="" disabled selected>Select Time</option>
                                        <option value="09.00 AM">09.00 AM</option>
                                        <option value="13.00 PM">13.00 PM</option>
                                        <option value="16.00 PM">16.00 PM</option>
                                        <option value="20.00 PM">20.00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="package">Select MCU Package</label>
                                    <select class="form-control" name="package" id="package" required
                                        style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;">
                                        <option value="" disabled selected>Select MCU Package</option>
                                        <option value="basic">Basic</option>
                                        <option value="standard">Standard</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="tourist-attractions" style="display: none; margin-top: 20px; padding: 15px; background-color: #e0f7fa; border-radius: 10px;">
                                    <h4 style="color: #003366; margin-bottom: 10px;">Tourist Attractions Included:</h4>
                                    <ul id="attractions-list" style="list-style-type: disc; padding-left: 20px;"></ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="destination" id="destination"> 
                        <div class="form-group-2 mb-4">
                            <label for="notes">Additional Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="6"
                                placeholder="Additional Notes (optional)"
                                style="border: 2px solid #003366; padding: 12px; border-radius: 10px; transition: all 0.3s ease;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-main btn-round-full"
                            style="background-color: #003366; color: #fff; padding: 14px 28px; border-radius: 30px; font-size: 16px; transition: all 0.3s ease;">
                            Register <i class="icofont-simple-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- End Pendaftaran MCU Section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const packageSelect = document.getElementById('package');
        const touristAttractions = document.getElementById('tourist-attractions');
        const attractionsList = document.getElementById('attractions-list');
        const destinationInput = document.getElementById('destination'); // Hidden input field

        packageSelect.addEventListener('change', function() {
            const selectedPackage = packageSelect.value;

            // Clear the attractions list
            attractionsList.innerHTML = '';

            // Show relevant attractions based on selected package
            let attractions = [];
            let destination = '';
            if (selectedPackage === 'basic') {
                destination = 'Destination Basic'; // Example value
                attractions = ['Bukit Paralayang', 'Malioboro'];
            } else if (selectedPackage === 'standard') {
                destination = 'Destination Standard'; // Example value
                attractions = ['Bukit Paralayang', 'Malioboro', 'Candi Prambanan'];
            } else if (selectedPackage === 'premium') {
                destination = 'Destination Premium'; // Example value
                attractions = ['Bukit Paralayang', 'Malioboro', 'Candi Prambanan', 'Candi Borobudur', 'Pantai Parangtritis'];
            } else {
                destination = ''; // Reset if no package selected
            }

            // Update the destination input field
            destinationInput.value = destination;

            // Populate the attractions list
            if (attractions.length > 0) {
                attractions.forEach(function(attraction) {
                    const listItem = document.createElement('li');
                    listItem.textContent = attraction;
                    attractionsList.appendChild(listItem);
                });
                touristAttractions.style.display = 'block';
            } else {
                touristAttractions.style.display = 'none';
            }
        });
    });
</script>


<!-- Testimonials Section -->
<section class="section testimonial-2 gray-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-title text-center">
                    <h2 class="font-weight-bold" style="color: #26355D;">We served over 1000+ Patients</h2>
                    <div class="divider mx-auto my-4"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Testimonial -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 testimonial-slider d-flex flex-nowrap overflow-auto pb-3" style="gap: 20px;">
                <div class="testimonial-block style-2 gray-bg p-4 mb-4" style="flex: 0 0 32%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <i class="icofont-quote-right" style="font-size: 24px; color: #6c757d;"></i>
                    <div class="testimonial-thumb my-3">
                        <img src="assets/images/team/rara.jpg" alt="Dara Amanda" class="img-fluid rounded-circle">
                    </div>
                    <div class="client-info">
                        <h4 class="font-weight-bold">Dara Amanda</h4>
                        <span class="text-muted">Lampung</span>
                        <p class="mt-3">HealthNav your travel companion for the best healthcare abroad! They have a safe, comfortable and quality service network. So, you can calm down and focus on recovery without worrying.</p>
                    </div>
                </div>

                <div class="testimonial-block style-2 gray-bg p-4 mb-4" style="flex: 0 0 32%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="testimonial-thumb my-3">
                        <img src="assets/images/team/iqbaal.jpg" alt="Iqbaal Ramadhan" class="img-fluid rounded-circle">
                    </div>
                    <div class="client-info">
                        <h4 class="font-weight-bold">Iqbaal Ramadhan</h4>
                        <span class="text-muted">Sleman</span>
                        <p class="mt-3">HealthNav has really helped my health journey! I felt safe, comfortable and received quality care abroad. Highly recommended for anyone seeking international medical services.</p>
                    </div>
                </div>

                <div class="testimonial-block style-2 gray-bg p-4 mb-4" style="flex: 0 0 32%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="testimonial-thumb my-3">
                        <img src="assets/images/team/kikow.jpg" alt="Ahmad Sholis" class="img-fluid rounded-circle">
                    </div>
                    <div class="client-info">
                        <h4 class="font-weight-bold">kikoww</h4>
                        <span class="text-muted">Gresik</span>
                        <p class="mt-3">With HealthNav, my medical travel has become very easy and safe. They offer high-quality service with the utmost comfort, making me feel at ease throughout the treatment process. Amazing service!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Tambah Testimoni -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <h4 class="mb-3">Tinggalkan Testimoni Anda</h4>
                <form id="testimonialForm">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Nama" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" id="location" placeholder="Kota" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="file" class="form-control" id="photo" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="message" rows="3" placeholder="Pesan Testimoni" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Testimoni</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.getElementById('testimonialForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const location = document.getElementById('location').value;
        const message = document.getElementById('message').value;
        const photoInput = document.getElementById('photo');
        const photo = photoInput.files[0];

        const reader = new FileReader();

        reader.onload = function(event) {
            const imgSrc = photo ? event.target.result : 'assets/images/default-profile.png';

            const testimonialHTML = `
                <div class="testimonial-block style-2 gray-bg p-4 mb-4" style="flex: 0 0 32%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <i class="icofont-quote-right" style="font-size: 24px; color: #6c757d;"></i>
                    <div class="testimonial-thumb my-3">
                        <img src="${imgSrc}" alt="${name}" class="img-fluid rounded-circle">
                    </div>
                    <div class="client-info">
                        <h4 class="font-weight-bold">${name}</h4>
                        <span class="text-muted">${location}</span>
                        <p class="mt-3">${message}</p>
                    </div>
                </div>`;

            document.querySelector('.testimonial-slider').insertAdjacentHTML('beforeend', testimonialHTML);
            document.getElementById('testimonialForm').reset();
        };

        if (photo) {
            reader.readAsDataURL(photo);
        } else {
            reader.onload(); // Jalankan manual jika tidak ada foto
        }
    });
</script>
@endsection