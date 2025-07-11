@extends('layouts.shared')

@section('content')
<!-- Enhanced Dashboard with Modern Design -->
<section class="dashboard-hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 col-md-7">
                <div class="hero-content" data-aos="fade-up">
                    <div class="welcome-badge mb-3">
                        <span class="badge-icon">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <span class="badge-text">Personal Dashboard</span>
                    </div>

                    <h1 class="hero-title mb-3">
                        Welcome,
                        <span class="gradient-text">{{ $user->name }}!</span>
                    </h1>

                    <p class="hero-subtitle mb-4">
                        Manage your medical tourism journey and track your health packages
                    </p>

                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $orders->count() }}</span>
                                <span class="stat-label">Total Orders</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $orders->where('payment_status', 'paid')->count() }}</span>
                                <span class="stat-label">Completed</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $orders->where('payment_status', '!=', 'paid')->count() }}</span>
                                <span class="stat-label">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-5">
                <div class="hero-actions" data-aos="fade-left" data-aos-delay="200">
                    <div class="action-card">
                        <div class="action-header">
                            <h5>Quick Actions</h5>
                            <p>Manage your account and bookings</p>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-action">
                                <i class="fas fa-user-edit me-2"></i>
                                Edit Profile
                            </a>
                            <a href="{{ route('packages') }}" class="btn btn-outline-primary btn-action">
                                <i class="fas fa-plus-circle me-2"></i>
                                New Booking
                            </a>
                            <!-- <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-action">
                                <i class="fas fa-headset me-2"></i>
                                Support
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Order History Section -->
<section class="order-history-section">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <!-- <div class="section-badge">
                <i class="fas fa-history me-2"></i>
                Order Management
            </div> -->
            <h2 class="section-title">Your Medical Journey History</h2>
            <p class="section-description">
                Track and manage all your medical tourism bookings and treatments
            </p>
        </div>

        @if($orders->count() > 0)
        <!-- Filter and Sort Options -->
        <!-- <div class="filter-section mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">
                            <i class="fas fa-list me-2"></i>All Orders
                        </button>
                        <button class="filter-tab" data-filter="paid">
                            <i class="fas fa-check-circle me-2"></i>Completed
                        </button>
                        <button class="filter-tab" data-filter="pending">
                            <i class="fas fa-clock me-2"></i>Pending
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sort-options">
                        <select class="form-select" id="sortOrders">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="price-low">Price: Low to High</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Orders Grid -->
        <div class="orders-grid" id="ordersGrid">
            <div class="row g-4">
                @foreach ($orders as $index => $order)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="order-card" data-status="{{ $order->payment_status }}" data-price="{{ $order->total_price }}" data-date="{{ $order->created_at->timestamp }}">
                        <!-- Status Badge -->
                        <div class="ribbon {{ $order->payment_status !== 'paid' ? 'ribbon-unpaid' : 'ribbon-paid' }}">
        <span>{{ strtoupper($order->payment_status) }}</span>
    </div>


                        <!-- Order Header -->
                        <div class="order-header">
                            <div class="order-code">
                                <i class="fas fa-receipt me-2"></i>
                                {{ $order->order_code }}
                            </div>
                            <div class="order-date">
                                <!-- {{ $order->created_at->format('M d, Y') }} -->
                            </div>
                        </div>

                        <!-- Package Info -->
                        <div class="package-info">
                            <div class="package-image">
                                @if($order->paket->gambar)
                                <img src="{{ asset('storage/' . $order->paket->gambar) }}" alt="{{ $order->paket->nama_paket }}">
                                @else
                                <div class="image-placeholder">
                                    <i class="fas fa-medical-kit"></i>
                                </div>
                                @endif
                                <div class="image-overlay">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>

                            <div class="package-details">
                                <h5 class="package-title">{{ $order->paket->nama_paket }}</h5>
                                <div class="package-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ \Carbon\Carbon::parse($order->booking_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-hospital"></i>
                                        <span>{{ $order->paket->rumahSakit->nama }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="price-label">Total Amount</div>
                            <div class="price-amount">
                                <span class="currency">Rp</span>
                                <span class="amount">{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="order-actions">
                            @if ($order->payment_status !== 'paid')
                            <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-primary btn-action-primary">
                                <i class="fas fa-file-invoice me-2"></i>
                                Pay Now
                            </a>
                            @else
                            <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-primary btn-action-primary">
                                <i class="fas fa-file-invoice me-2"></i>
                                View Invoice
                            </a>
                            @endif

                            @if ($order->payment_status !== 'paid')
                            <!-- <a href="{{ route('bayar.midtrans', $order->id) }}" class="btn btn-success btn-action-secondary">
                                <i class="fas fa-credit-card me-2"></i>
                                Pay Now
                            </a> -->
                            @else
                            <!-- <button class="btn btn-outline-success btn-action-secondary" disabled>
                                <i class="fas fa-check me-2"></i>
                                Paid
                            </button> -->
                            @endif
                        </div>

                        <!-- Progress Indicator -->
                        <div class="progress-indicator">
                            <div class="progress-step {{ $order->payment_status === 'paid' || $order->payment_status === 'pending' ? 'completed' : '' }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Ordered</span>
                            </div>
                            <div class="progress-line {{ $order->payment_status === 'paid' ? 'completed' : '' }}"></div>
                            <div class="progress-step {{ $order->payment_status === 'paid' ? 'completed' : '' }}">
                                <i class="fas fa-credit-card"></i>
                                <span>Paid</span>
                            </div>
                            <!-- <div class="progress-line"></div> -->
                            <!-- <div class="progress-step">
                                <i class="fas fa-calendar-check"></i>
                                <span>Scheduled</span>
                            </div> -->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <!-- Enhanced Empty State -->
        <div class="empty-state" data-aos="fade-up">
            <div class="empty-illustration">
                <div class="empty-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="empty-shapes">
                    <div class="empty-shape shape-1"></div>
                    <div class="empty-shape shape-2"></div>
                    <div class="empty-shape shape-3"></div>
                </div>
            </div>

            <div class="empty-content">
                <h4>Start Your Health Journey</h4>
                <p>You haven't made any bookings yet. Explore our premium medical tourism packages and begin your path to better health.</p>

                <!-- <div class="empty-actions">
                    <a href="{{ route('packages') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>
                        Browse Packages
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-info-circle me-2"></i>
                        Learn More
                    </a>
                </div> -->

                <!-- <div class="empty-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Safe & Secure</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-award"></i>
                        <span>Premium Quality</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-headset"></i>
                        <span>24/7 Support</span>
                    </div>
                </div> -->
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Enhanced Custom Styles -->
<style>
    /* Enhanced Global Variables */
    :root {
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --primary-light: #66b3ff;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #1a1a1a;
        --secondary-color: #6c757d;
        --gradient-primary: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        --gradient-warning: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        --gradient-danger: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 5px 20px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 15px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Enhanced Dashboard Hero */
    .dashboard-hero {
        min-height: 60vh;
        position: relative;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 50%, #f0f8ff 100%);
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

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset("assets/images/apa.jpg") }}') no-repeat center;
        background-size: cover;
        opacity: 0.1;
    }

    .hero-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.1), rgba(0, 86, 179, 0.05));
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 200px;
        height: 200px;
        top: 10%;
        right: 10%;
        animation-delay: 0s;
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

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 10px 20px;
        border-radius: 50px;
        border: 1px solid rgba(0, 123, 255, 0.2);
        box-shadow: var(--shadow-sm);
    }

    .badge-icon {
        width: 25px;
        height: 25px;
        background: var(--gradient-primary);
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
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.2;
        color: var(--dark-color);
    }

    .gradient-text {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        color: var(--secondary-color);
        line-height: 1.6;
    }

    /* User Stats */
    .user-stats {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 123, 255, 0.1);
        transition: var(--transition);
    }

    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--secondary-color);
        font-weight: 500;
    }

    /* Hero Actions */
    .hero-actions {
        position: relative;
        z-index: 2;
    }

    .action-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .action-header h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 5px;
    }

    .action-header p {
        color: var(--secondary-color);
        font-size: 0.9rem;
        margin-bottom: 25px;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-action {
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Order History Section */
    .order-history-section {
        padding: 80px 0;
        background: white;
    }

    .section-header {
        max-width: 600px;
        margin: 0 auto;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(0, 123, 255, 0.1);
        color: var(--primary-color);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 15px;
    }

    .section-description {
        font-size: 1.1rem;
        color: var(--secondary-color);
        line-height: 1.6;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 123, 255, 0.05);
    }

    .filter-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-tab {
        background: transparent;
        border: 2px solid #e9ecef;
        color: var(--secondary-color);
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .filter-tab:hover,
    .filter-tab.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .sort-options {
        display: flex;
        justify-content: flex-end;
    }

    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 10px 15px;
        font-weight: 500;
        transition: var(--transition);
        max-width: 200px;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    /* Enhanced Order Cards */
    .order-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 123, 255, 0.05);
        transition: var(--transition);
        position: relative;
        height: 100%;
    }

    .order-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .ribbon {
    width: 120px;
    height: 120px;
    overflow: hidden;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 99;
}

.ribbon span {
    position: absolute;
    display: block;
    width: 180px;
    padding: 4px 0;
    background-color: #28a745; /* default: green */
    color: #fff;
    text-align: center;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
    transform: rotate(45deg);
    top: 18px;                 /* naik sedikit agar seimbang */
    right: -40px;             /* geser kiri agar teks di tengah */
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    letter-spacing: 0.5px;
    line-height: 2
}


/* Warna Berdasarkan Status */
.ribbon-paid span {
    background-color: #28a745;
}

.ribbon-unpaid span {
    background-color: #dc3545;
}


    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
        backdrop-filter: blur(10px);
    }

    .status-paid {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.9);
        color: white;
    }

    .status-failed {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    /* Order Header */
    .order-header {
        padding: 20px 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-code {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
        display: flex;
        align-items: center;
    }

    .order-date {
        font-size: 0.9rem;
        color: var(--secondary-color);
        font-weight: 500;
    }

    /* Package Info */
    .package-info {
        padding: 20px;
    }

    .package-image {
        position: relative;
        width: 100%;
        height: 150px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .package-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    /* .order-card:hover .package-image img {
        transform: scale(1.1);
    } */

    .image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
        font-size: 2rem;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 123, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        opacity: 0;
        transition: var(--transition);
    }

    /* .order-card:hover .image-overlay {
        opacity: 1;
    } */

    .package-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .package-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--secondary-color);
    }

    .meta-item i {
        color: var(--primary-color);
        width: 16px;
    }

    /* Price Section */
    .price-section {
        padding: 0 20px 20px;
        border-bottom: 1px solid rgba(0, 123, 255, 0.1);
    }

    .price-label {
        font-size: 0.8rem;
        color: var(--secondary-color);
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .price-amount {
        display: flex;
        align-items: baseline;
        gap: 2px;
    }

    .currency {
        font-size: 1rem;
        color: var(--secondary-color);
        font-weight: 600;
    }

    .amount {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    /* Action Buttons */
    .order-actions {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-action-primary,
    .btn-action-secondary {
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .btn-action-primary {
        background: var(--gradient-primary);
        color: white;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-action-secondary {
        background: var(--gradient-success);
        color: white;
    }

    .btn-action-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
    }

    /* Progress Indicator */
    .progress-indicator {
        padding: 20px;
        background: rgba(0, 123, 255, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        flex: 1;
        position: relative;
    }

    .progress-step i {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #e9ecef;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .progress-step.completed i {
        background: var(--gradient-primary);
        color: white;
    }

    .progress-step span {
        font-size: 0.7rem;
        color: var(--secondary-color);
        font-weight: 500;
        text-align: center;
    }

    .progress-step.completed span {
        color: var(--primary-color);
        font-weight: 600;
    }

    .progress-line {
        height: 2px;
        background: #e9ecef;
        flex: 1;
        margin: 0 10px;
        position: relative;
        top: -15px;
    }

    .progress-line.completed {
        background: var(--primary-color);
    }

    /* Enhanced Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        position: relative;
    }

    .empty-illustration {
        position: relative;
        margin-bottom: 40px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 86, 179, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        position: relative;
        z-index: 2;
    }

    .empty-icon i {
        font-size: 3rem;
        color: var(--primary-color);
        opacity: 0.7;
    }

    .empty-shapes {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 120px;
    }

    .empty-shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.05), rgba(0, 86, 179, 0.02));
        animation: float 4s ease-in-out infinite;
    }

    .empty-shape.shape-1 {
        width: 60px;
        height: 60px;
        top: 0;
        left: 0;
        animation-delay: 0s;
    }

    .empty-shape.shape-2 {
        width: 40px;
        height: 40px;
        top: 20px;
        right: 0;
        animation-delay: 1s;
    }

    .empty-shape.shape-3 {
        width: 30px;
        height: 30px;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        animation-delay: 2s;
    }

    .empty-content h4 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 15px;
    }

    .empty-content p {
        font-size: 1.1rem;
        color: var(--secondary-color);
        line-height: 1.6;
        margin-bottom: 40px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .empty-actions .btn {
        padding: 15px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .empty-actions .btn:hover {
        transform: translateY(-3px);
    }

    .empty-features {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .feature-item i {
        width: 50px;
        height: 50px;
        background: rgba(0, 123, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .feature-item span {
        font-size: 0.9rem;
        color: var(--secondary-color);
        font-weight: 500;
    }

    /* Animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-15px) rotate(5deg);
        }
    }

    /* Enhanced Responsive Design */
    @media (max-width: 1200px) {
        .user-stats {
            gap: 20px;
        }

        .stat-item {
            padding: 15px;
        }

        .empty-features {
            gap: 30px;
        }
    }

    @media (max-width: 992px) {
        .dashboard-hero {
            min-height: 50vh;
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2.5rem;
            text-align: center;
        }

        .hero-subtitle {
            text-align: center;
        }

        .user-stats {
            justify-content: center;
            margin-top: 30px;
        }

        .action-card {
            margin-top: 30px;
        }

        .filter-section {
            padding: 20px;
        }

        .filter-tabs {
            justify-content: center;
            margin-bottom: 20px;
        }

        .sort-options {
            justify-content: center;
        }

        .form-select {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            min-height: auto;
            padding: 50px 0;
        }

        .hero-title {
            font-size: 2rem;
        }

        .user-stats {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .stat-item {
            width: 100%;
            max-width: 300px;
        }

        .action-buttons {
            gap: 10px;
        }

        .section-title {
            font-size: 2rem;
        }

        .filter-tabs {
            flex-direction: column;
            align-items: center;
        }

        .filter-tab {
            width: 100%;
            max-width: 200px;
            justify-content: center;
        }

        .order-actions {
            padding: 15px;
        }

        .progress-indicator {
            padding: 15px;
        }

        .progress-step span {
            font-size: 0.6rem;
        }

        .empty-actions {
            flex-direction: column;
            align-items: center;
        }

        .empty-actions .btn {
            width: 100%;
            max-width: 250px;
        }

        .empty-features {
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-hero {
            padding: 40px 0;
        }

        .hero-title {
            font-size: 1.8rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .welcome-badge {
            padding: 8px 16px;
        }

        .badge-text {
            font-size: 0.8rem;
        }

        .stat-item {
            padding: 12px;
            gap: 10px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .action-card {
            padding: 20px;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .section-description {
            font-size: 1rem;
        }

        .filter-section {
            padding: 15px;
        }

        .order-header {
            padding: 15px 15px 0;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .package-info {
            padding: 15px;
        }

        .package-image {
            height: 120px;
        }

        .package-title {
            font-size: 1.1rem;
        }

        .price-section {
            padding: 0 15px 15px;
        }

        .amount {
            font-size: 1.5rem;
        }

        .order-actions {
            padding: 15px;
            gap: 8px;
        }

        .btn-action-primary,
        .btn-action-secondary {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .progress-indicator {
            padding: 10px;
        }

        .progress-step i {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .progress-line {
            margin: 0 5px;
            top: -12px;
        }

        .empty-state {
            padding: 50px 15px;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
        }

        .empty-icon i {
            font-size: 2.5rem;
        }

        .empty-content h4 {
            font-size: 1.5rem;
        }

        .empty-content p {
            font-size: 1rem;
        }

        .empty-features {
            flex-direction: column;
            gap: 15px;
        }
    }

    /* Print Styles */
    @media print {

        .hero-shapes,
        .empty-shapes,
        .shape,
        .empty-shape,
        .image-overlay,
        .action-card {
            display: none !important;
        }

        .dashboard-hero,
        .order-history-section {
            padding: 20px 0 !important;
        }

        .order-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            margin-bottom: 20px;
        }

        .status-badge {
            position: static !important;
            display: inline-flex !important;
            margin-bottom: 10px;
        }
    }

    /* Accessibility Improvements */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        .shape,
        .empty-shape {
            animation: none !important;
        }
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {

        .order-card,
        .action-card,
        .filter-section {
            border: 2px solid var(--dark-color) !important;
        }

        .btn-primary,
        .btn-action-primary {
            background: var(--dark-color) !important;
            border: 2px solid var(--dark-color) !important;
        }

        .status-badge {
            border: 1px solid var(--dark-color) !important;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    // Enhanced JavaScript for Dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS (Animate On Scroll)
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        }

        // Filter functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        const orderCards = document.querySelectorAll('.order-card');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                filterTabs.forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                orderCards.forEach(card => {
                    const status = card.getAttribute('data-status');

                    if (filter === 'all' || status === filter) {
                        card.parentElement.style.display = 'block';
                        // Add animation
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                });
            });
        });

        // Sort functionality
        const sortSelect = document.getElementById('sortOrders');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortValue = this.value;
                const ordersGrid = document.getElementById('ordersGrid');
                const orderRows = Array.from(ordersGrid.querySelectorAll('.col-lg-4'));

                orderRows.sort((a, b) => {
                    const cardA = a.querySelector('.order-card');
                    const cardB = b.querySelector('.order-card');

                    switch (sortValue) {
                        case 'newest':
                            return parseInt(cardB.getAttribute('data-date')) - parseInt(cardA.getAttribute('data-date'));
                        case 'oldest':
                            return parseInt(cardA.getAttribute('data-date')) - parseInt(cardB.getAttribute('data-date'));
                        case 'price-high':
                            return parseInt(cardB.getAttribute('data-price')) - parseInt(cardA.getAttribute('data-price'));
                        case 'price-low':
                            return parseInt(cardA.getAttribute('data-price')) - parseInt(cardB.getAttribute('data-price'));
                        default:
                            return 0;
                    }
                });

                // Re-append sorted elements
                const rowContainer = ordersGrid.querySelector('.row');
                orderRows.forEach(row => {
                    rowContainer.appendChild(row);
                });

                // Add animation to sorted items
                orderRows.forEach((row, index) => {
                    const card = row.querySelector('.order-card');
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
                });
            });
        }

        // Enhanced hover effects for order cards
        orderCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Notification system for actions
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                ${message}
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

            // Add notification styles if not exists
            if (!document.querySelector('#notification-styles')) {
                const styles = document.createElement('style');
                styles.id = 'notification-styles';
                styles.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    border-radius: 12px;
                    padding: 15px 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                    border-left: 4px solid var(--primary-color);
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    max-width: 400px;
                    animation: slideInRight 0.3s ease;
                }
                .notification-success { border-left-color: var(--success-color); }
                .notification-error { border-left-color: var(--danger-color); }
                .notification-content { flex: 1; font-weight: 500; }
                .notification-close {
                    background: none;
                    border: none;
                    color: var(--secondary-color);
                    cursor: pointer;
                    padding: 5px;
                    border-radius: 50%;
                    transition: var(--transition);
                }
                .notification-close:hover {
                    background: rgba(0, 0, 0, 0.1);
                }
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
                document.head.appendChild(styles);
            }

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideInRight 0.3s ease reverse';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Add click handlers for action buttons
        document.querySelectorAll('.btn-action-primary, .btn-action-secondary').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                this.disabled = true;

                // Simulate loading (remove this in production)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }

            // Add keyboard shortcuts
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case '1':
                        e.preventDefault();
                        document.querySelector('[data-filter="all"]')?.click();
                        break;
                    case '2':
                        e.preventDefault();
                        document.querySelector('[data-filter="paid"]')?.click();
                        break;
                    case '3':
                        e.preventDefault();
                        document.querySelector('[data-filter="pending"]')?.click();
                        break;
                }
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });

        // Add tooltips for better UX
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'custom-tooltip';
                tooltip.textContent = this.getAttribute('data-tooltip');
                document.body.appendChild(tooltip);

                const rect = this.getBoundingClientRect();
                tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            });

            element.addEventListener('mouseleave', function() {
                const tooltip = document.querySelector('.custom-tooltip');
                if (tooltip) tooltip.remove();
            });
        });

        // Performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', () => {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log(`Dashboard loaded in ${loadTime}ms`);
            });
        }
    });

    // Add custom tooltip styles
    const tooltipStyles = document.createElement('style');
    tooltipStyles.textContent = `
    .custom-tooltip {
        position: absolute;
        background: var(--dark-color);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        z-index: 10000;
        pointer-events: none;
        opacity: 0;
        animation: fadeIn 0.2s ease forwards;
    }
    
    .custom-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: var(--dark-color);
    }
    
    @keyframes fadeIn {
        to { opacity: 1; }
    }
`;
    document.head.appendChild(tooltipStyles);
</script>

<!-- Add AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

@endsection