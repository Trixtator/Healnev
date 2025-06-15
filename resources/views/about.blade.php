@extends('layouts.shared')
@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <h1 class="text-capitalize mb-5 text-lg">About Us</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section about-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h2 class="title-color" style="color: #26355D;">HealthNav</h2>
                <p class="subtitle">Your Personal Healthcare Navigator</p>
            </div>
            <div class="col-lg-8">
                <p style="text-align: justify;">HealthNAV (Health Navigation) is an innovative platform designed to revolutionize your healthcare
                    experience, especially in the realm of medical tourism. Our mission is to empower you with the
                    knowledge and tools to navigate the complex world of healthcare seamlessly, ensuring that you
                    receive the best possible care tailored to your individual needs.</p>
                <p style="text-align: justify;">With HealthNAV, you can discover a world of healthcare options at your fingertips. Whether you're
                    seeking treatment abroad or looking for local healthcare services, HealthNAV is your trusted guide.
                    Our platform provides comprehensive information on healthcare providers, treatments, and
                    destinations, empowering you to make informed decisions about your health.</p>
                <p style="text-align: justify;">But HealthNAV is more than just an information hub. We're your personal healthcare companion,
                    dedicated to ensuring your well-being every step of the way. From assisting you in selecting the
                    right medical destination to providing support throughout your treatment journey, HealthNAV is
                    committed to making your healthcare experience stress-free and seamless.</p>
                <p style="text-align: justify;">At HealthNAV, we understand that your health is personal. That's why we're committed to delivering
                    personalized healthcare solutions that cater to your unique needs. Whether you're planning a medical
                    trip or seeking local healthcare services, HealthNAV is here to guide you towards a healthier,
                    happier life.</p>
                <p style="text-align: justify;">Join us on a journey towards better health with HealthNAV. Discover a world of healthcare
                    possibilities, tailored to your needs.</p>
            </div>
        </div>
    </div>
</section>


<!-- <section class="section team" id="basic-mcu">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2 class="font-weight-bold" style="color: #003366;">Discover Our Comprehensive Health Check Packages</h2>
                    <p class="lead" style="font-size: 1.25rem; color: #555;">Basic, Standard, and Premium</p>
                    <div class="divider mx-auto my-4" style="background-color: #007bff; height: 2px; width: 60px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="section-title text-center">
                <h2 class="mb-4" style="color: #003366; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; position: relative; display: inline-block;">
                    Basic Package
                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #003366;"></span>
                </h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Blood Pressure Measurement</h4>
                    <p style="text-align: justify;">Measurement of the force of blood against the walls of blood vessels. Important for monitoring heart health and the risk of cardiovascular disease.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Basic Blood Test</h4>
                    <p style="text-align: justify;">Routine laboratory tests to evaluate overall health, including glucose levels, cholesterol, liver function, kidney function, and blood cell counts.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Basic Health Check Package</h4>
                    <p style="text-align: justify;">The basic health check package includes various essential tests to assess overall health. This includes blood pressure measurement, basic blood tests, and general physical examination.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">General Physical Examination</h4>
                    <p style="text-align: justify;">Physical evaluation by a doctor to assess the overall condition of the body, such as weight, height, blood pressure, pulse, respiration, and organ examination. Used to assess general health and detect health problems.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section team" id="standard-mcu">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title text-center">
                    <h2 class="mb-4" style="color: #003366; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; position: relative; display: inline-block;">
                        Standard Package
                        <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #003366;"></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Blood Pressure Measurement</h4>
                    <p>Measurement of the force of blood against the walls of blood vessels. Important for monitoring heart health and the risk of cardiovascular disease.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Basic Blood Test</h4>
                    <p>Routine laboratory tests to evaluate overall health, including glucose levels, cholesterol, liver function, kidney function, and blood cell counts.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">General Physical Examination</h4>
                    <p>Physical evaluation by a doctor to assess the overall condition of the body, such as weight, height, blood pressure, pulse, respiration, and organ examination. Used to assess general health and detect health problems.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Cholesterol Test</h4>
                    <p>A test to measure the amount of cholesterol in the blood. Cholesterol is a fat that is important for body function, but high levels can increase the risk of heart disease.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">ECG (Electrocardiogram)</h4>
                    <p>A test to record the electrical activity of the heart. Used to detect heart problems such as arrhythmias or heart damage.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Complete Blood Count</h4>
                    <p>A test to measure various components of the blood such as red blood cells, white blood cells, and platelets. Used to assess overall health and detect conditions such as anemia, infection, or blood clotting disorders.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section team" id="premium-mcu">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title text-center">
                    <h2 class="mb-4" style="color: #003366; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; position: relative; display: inline-block;">
                        Premium Package
                        <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #003366;"></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Blood Pressure Measurement</h4>
                    <p>Measurement of the force of blood against the walls of blood vessels. Important for monitoring heart health and the risk of cardiovascular disease.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Basic Blood Test</h4>
                    <p>Routine laboratory tests to evaluate overall health, including glucose levels, cholesterol, liver function, kidney function, and blood cell counts.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">General Physical Examination</h4>
                    <p>Physical evaluation by a doctor to assess the overall condition of the body, such as weight, height, blood pressure, pulse, respiration, and organ examination. Used to assess general health and detect health problems.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Cholesterol Test</h4>
                    <p>A test to measure the amount of cholesterol in the blood. Cholesterol is a fat that is important for body function, but high levels can increase the risk of heart disease.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">ECG (Electrocardiogram)</h4>
                    <p>A test to record the electrical activity of the heart. Used to detect heart problems such as arrhythmias or heart damage.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-3.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Complete Blood Count</h4>
                    <p>A test to measure various components of the blood such as red blood cells, white blood cells, and platelets. Used to assess overall health and detect conditions such as anemia, infection, or blood clotting disorders.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="about-block-item mb-5 mb-lg-0">
                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="" class="img-fluid w-100">
                    <h4 class="mt-3">Liver Function Test</h4>
                    <p>Laboratory tests to evaluate liver function and detect conditions such as liver inflammation, liver damage, or liver disease.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="section-title">
                    <h2 class="mb-4">What they say about us</h2>
                    <div class="divider  my-4"></div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 testimonial-wrap offset-lg-6">
                <div class="testimonial-block">
                    <div class="client-info ">
                        <h4>Amazing service!</h4>
                        <span>Alex Rizky</span>
                    </div>
                    <p>
                        HealthNav provides great service! I was very impressed with
                        the services they provide. The doctors are very experienced and friendly,
                        made my visit enjoyable and gave me confidence
                        more related to my health.
                    </p>
                    <i class="icofont-quote-right"></i>
                </div>
                <div class="testimonial-block">
                    <div class="client-info">
                        <h4>Expert doctors!</h4>
                        <span>Chris John</span>
                    </div>
                    <p>
                        HealthNav has expert doctors who are very experienced and competent.
                        I feel safe and confident in dealing with my health problems because
                        supported by a reliable medical team at HealthNav.
                    </p>
                    <i class="icofont-quote-right"></i>
                </div>
                <div class="testimonial-block">
                    <div class="client-info">
                        <h4>Good Support!</h4>
                        <span>Amalia Rahmadhani</span>
                    </div>
                    <p>
                        The HealthNav team provided great support. They were very responsive and helpful
                        helpful in answering our questions. Their support made our experience
                        with HealthNav it gets better.
                    </p>
                    <i class="icofont-quote-right"></i>
                </div>
                <div class="testimonial-block">
                    <div class="client-info">
                        <h4>Nice Environment!</h4>
                        <span>Neymar Jr.</span>
                    </div>
                    <p>
                        HealthNav provides an exceptional healthcare experience with
                        comfortable and clean environment. We felt very comfortable and at ease throughout
                        our visit. Thank you HealthNav!
                    </p>
                    <i class="icofont-quote-right"></i>
                </div>
                <div class="testimonial-block">
                    <div class="client-info">
                        <h4>Modern Service!</h4>
                        <span>David Beckham</span>
                    </div>
                    <p>
                        Take your healthcare to the next level with HealthNav!
                        Our experience with their services was truly outstanding. They deliver
                        a modern and practical solution for every one of our health needs. Very
                        recommended!
                    </p>
                    <i class="icofont-quote-right"></i>
                </div>
            </div>
        </div>
    </div> -->
</section>
@endsection