@extends('layouts.loglayout')

@section('title', 'Data Rumah Sakit - HealthNav Admin')

@section('content')
<!-- Enhanced Hospital Management Page -->
<div class="admin-wrapper">
    <div class="admin-background">
        <div class="admin-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>

    <div class="admin-container">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-down">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <i class="fas fa-hospital me-3"></i>
                        Data Rumah Sakit
                    </h1>
                    <p class="page-subtitle">Kelola informasi rumah sakit dan fasilitas kesehatan</p>
                </div>
                <div class="header-actions">
                    <button class="btn-primary" id="addHospitalBtn">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Rumah Sakit
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">15</h3>
                    <p class="stat-label">Total Rumah Sakit</p>
                </div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+2 Baru</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">12</h3>
                    <p class="stat-label">Aktif</p>
                </div>
                <div class="stat-trend success">
                    <i class="fas fa-arrow-up"></i>
                    <span>80%</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">2</h3>
                    <p class="stat-label">Pending Review</p>
                </div>
                <div class="stat-trend warning">
                    <i class="fas fa-clock"></i>
                    <span>Review</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">4.8</h3>
                    <p class="stat-label">Rating Rata-rata</p>
                </div>
                <div class="stat-trend info">
                    <i class="fas fa-arrow-up"></i>
                    <span>+0.2</span>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section" data-aos="fade-up" data-aos-delay="200">
            <div class="search-card">
                <div class="search-header">
                    <h3 class="search-title">
                        <i class="fas fa-search me-2"></i>
                        Cari & Filter Rumah Sakit
                    </h3>
                    <div class="search-actions">
                        <button class="btn-filter" id="advancedFilterBtn">
                            <i class="fas fa-filter me-2"></i>
                            Filter Lanjutan
                        </button>
                        <button class="btn-export">
                            <i class="fas fa-download me-2"></i>
                            Export Data
                        </button>
                    </div>
                </div>

                <form class="search-form">
                    <div class="search-row">
                        <div class="search-group">
                            <label for="hospitalSearch" class="search-label">
                                <i class="fas fa-hospital me-2"></i>
                                Nama Rumah Sakit
                            </label>
                            <div class="search-input-wrapper">
                                <input
                                    type="text"
                                    id="hospitalSearch"
                                    name="search"
                                    class="search-input"
                                    placeholder="Cari nama rumah sakit...">
                                <button type="submit" class="search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="search-group">
                            <label for="cityFilter" class="search-label">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Kota
                            </label>
                            <select name="city" id="cityFilter" class="search-select">
                                <option value="">Semua Kota</option>
                                <option value="jakarta">Jakarta</option>
                                <option value="surabaya">Surabaya</option>
                                <option value="bandung">Bandung</option>
                                <option value="medan">Medan</option>
                                <option value="yogyakarta">Yogyakarta</option>
                            </select>
                        </div>

                        <div class="search-group">
                            <label for="typeFilter" class="search-label">
                                <i class="fas fa-building me-2"></i>
                                Tipe Rumah Sakit
                            </label>
                            <select name="type" id="typeFilter" class="search-select">
                                <option value="">Semua Tipe</option>
                                <option value="government">Pemerintah</option>
                                <option value="private">Swasta</option>
                                <option value="international">Internasional</option>
                            </select>
                        </div>
                    </div>

                    <div class="search-actions-row">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search me-2"></i>
                            Cari Rumah Sakit
                        </button>
                        <button type="reset" class="btn-reset">
                            <i class="fas fa-undo me-2"></i>
                            Reset Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hospital Cards Section -->
        <div class="hospitals-section" data-aos="fade-up" data-aos-delay="300">
            <div class="hospitals-header">
                <div class="hospitals-title-section">
                    <h3 class="hospitals-title">
                        <i class="fas fa-list me-2"></i>
                        Daftar Rumah Sakit
                    </h3>
                    <p class="hospitals-subtitle">Kelola semua data rumah sakit</p>
                </div>
                <div class="view-controls">
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <select class="sort-select" id="sortSelect">
                        <option value="name">Urutkan: Nama</option>
                        <option value="rating">Urutkan: Rating</option>
                        <option value="city">Urutkan: Kota</option>
                        <option value="date">Urutkan: Tanggal</option>
                    </select>
                </div>
            </div>

            <div class="hospitals-grid" id="hospitalsGrid">
                <!-- Sample Hospital Cards -->
                <div class="hospital-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="hospital-image">
                        <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=400&h=250&fit=crop" alt="RS Siloam">
                        <div class="hospital-badge">
                            <span class="badge-premium">Premium</span>
                        </div>
                        <div class="hospital-status status-active">
                            <i class="fas fa-circle"></i>
                            Aktif
                        </div>
                    </div>

                    <div class="hospital-content">
                        <div class="hospital-header">
                            <h4 class="hospital-name">RS Siloam Hospitals</h4>
                            <div class="hospital-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-score">4.9</span>
                            </div>
                        </div>

                        <div class="hospital-info">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jakarta Selatan</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <span>+62 21 7506 1000</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-building