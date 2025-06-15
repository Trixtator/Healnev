@extends('layouts.shared')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">Contact Us</h1>

                    <!-- <ul class="list-inline breadcumb-nav">
              <li class="list-inline-item"><a href="index.html" class="text-white">Home</a></li>
              <li class="list-inline-item"><span class="text-white">/</span></li>
              <li class="list-inline-item"><a href="#" class="text-white-50">Contact Us</a></li>
            </ul> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact form start -->

<section class="section contact-info pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="contact-block mb-4 mb-lg-0">
                    <a href="https://wa.me/6285803061558" target="_blank">
                        <i class="icofont-brand-whatsapp"></i>
                        <h5>WhatsApp Us</h5>
                        085803061558
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="contact-block mb-4 mb-lg-0">
                    <a href="https://mail.google.com/mail/?view=cm&to=HealthNAV@gmail.com">
                        <i class="icofont-support-faq"></i>
                        <h5>Email Us</h5>
                        HealthNAV@gmail.com
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="contact-block mb-4 mb-lg-0">
                    <a href="https://maps.app.goo.gl/oUQLB7K66SM8jM6h8" target="_blank">
                        <i class="icofont-location-pin"></i>
                        <h5>Location</h5>
                        Siloam Hospitals Yogyakarta
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="map-container">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
            <iframe class="w-100 rounded" height="320px"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31624.482800983747!2d110.35482931083983!3d-7.783426400000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59c55cef4c69%3A0xc020b62112edd35e!2sSiloam%20Hospitals%20Yogyakarta!5e0!3m2!1sen!2sid!4v1717258696006!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<style>
    .contact-block a {
        display: block;
        color: inherit;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-block a:hover {
        color: #223a66;
        transform: translateY(-5px);
    }

    .map-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
</style>

@endsection