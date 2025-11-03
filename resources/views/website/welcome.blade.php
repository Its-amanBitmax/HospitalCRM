
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediCare Hospital | Excellence in Healthcare')</title>
    <link rel="icon" type="image/png" href="{{ $favicon }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #0B717A;
            --secondary: #1A3A40;
            --accent: #ff6b6b;
            --light: #f0f7f7;
            --dark: #1e293b;
            --gradient: linear-gradient(135deg, #0B717A, #00d4d4);
            --glass: rgba(255, 255, 255, 0.12);
            --border-glass: rgba(255, 255, 255, 0.25);
            --text-light: #e0f7f7;
            --neon-red: #ff1744;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter', sans-serif; }
        body { background:#f8f8f8; color:#1a202c; }
        a { text-decoration:none; color:inherit; }

        /* Floating Particles */
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; }
        .particle { position: absolute; background: rgba(11, 113, 122, 0.08); border-radius: 50%; animation: float 20s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.6; } 50% { transform: translateY(-120px) rotate(180deg); opacity: 1; } }

        /* Mouse Glow */
        .mouse-glow { position: fixed; width: 500px; height: 500px; background: radial-gradient(circle, rgba(11,113,122,0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; transform: translate(-50%, -50%); z-index: 0; transition: 0.4s ease-out; filter: blur(20px); }

        /* Navbar */
        .navbar { position: fixed; top: 0; width: 100%; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); z-index: 1000; padding: 1rem 5%; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .navbar .container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.5rem; color: var(--primary); }
        .logo img { height: 45px; border-radius: 8px; }
        .nav-links { display: flex; gap: 2.5rem; }
        .nav-links a { font-weight: 600; color: #333; transition: color 0.3s ease; position: relative; }
        .nav-links a::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 0; height: 3px; background: var(--accent); transition: width 0.3s ease; }
        .nav-links a:hover { color: var(--primary); }
        .nav-links a:hover::after { width: 100%; }
        .mobile-toggle { display: none; font-size: 1.5rem; cursor: pointer; color: var(--primary); }

        /* Scrolling Text */
        .scrolling-text { background: var(--gradient); color: white; padding: 16px 0; font-weight: 600; font-size: 16px; overflow: hidden; white-space: nowrap; box-shadow: 0 8px 25px rgba(11, 113, 122, 0.2); z-index: 10; }
        .scrolling-text span { display: inline-block; padding-left: 100%; animation: scroll 20s linear infinite; }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

        /* Hero */
        .hero { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; padding: 6rem 5%; background: var(--light); color: var(--text-light); position: relative; overflow: hidden; width: 100%;}
        .hero-text { flex: 1 1 500px; z-index: 2; }
        .hero-text span { font-size: 0.9rem; letter-spacing: 2px; color: var(--primary); text-transform: uppercase; font-weight: 500; }
        .hero-text h1 { font-size: 3rem; margin: 1rem 0; line-height: 1.2; color: var(--primary); }
        .hero-text p { font-size: 1rem; color: #555; margin-bottom: 2rem; line-height: 1.5; max-width: 450px; }
        .hero-text .btn { display: inline-block; background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 0.8rem 2rem; border-radius: 50px; font-weight: 600; transition: 0.3s; margin-right: 1rem; }
        .hero-text .btn:hover { background: var(--primary); color: #fff; }
        .hero-text .btn-video { display: inline-flex; align-items: center; font-weight: 500; color: #fff; }
        .hero-text .btn-video::before { content: "Play"; margin-right: 0.5rem; font-size: 0.9rem; }
        .hero-images { flex: 1 1 400px; display: flex; gap: 2rem; justify-content: center; position: relative; }
        .hero-images::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(var(--primary) 2px, transparent 2px); background-size: 15px 15px; z-index: 0; opacity: 0.3; }
        .hero-images img { border-radius: 50px; width: 200px; height: 300px; object-fit: cover; transition: transform 0.5s, box-shadow 0.5s; cursor: pointer; position: relative; z-index: 1; }
        .hero-images img:hover { transform: translateY(-15px) scale(1.05) rotate(-2deg); box-shadow: 0 25px 50px rgba(0,255,255,0.4); z-index: 2; }

        /* Health Gateway */
        .health-gateway { padding: 90px 20px 120px; background: linear-gradient(135deg, #e6f7f7, #f0f7f7); }
        .section-title { text-align: center; font-family: 'Playfair Display', serif; font-size: 3.8rem; color: var(--primary); margin-bottom: 22px; position: relative; }
        .section-title::after { content: ''; width: 120px; height: 6px; background: var(--accent); display: block; margin: 20px auto; border-radius: 3px; }
        .section-subtitle { text-align: center; font-size: 1.22rem; color: #444; max-width: 800px; margin: 0 auto 55px; line-height: 1.75; }
        .boxes { display: grid; grid-template-columns: repeat(4, 1fr); gap: 35px; max-width: 1400px; margin: 70px auto 0; padding: 0 20px; }
        .box { background: #ffffff; border-radius: 24px; padding: 45px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.09); transition: all 0.45s ease; border: 2.5px solid #58c7d6; cursor: pointer; position: relative; overflow: hidden; }
        .box::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, #0B717A, #00d4d4); transform: scaleX(0); transform-origin: left; transition: transform 0.45s ease; }
        .box:hover::before { transform: scaleX(1); }
        .box i { font-size: 3.5rem; color: #0B717A; margin-bottom: 22px; transition: all 0.45s ease; }
        .box h3 { font-size: 1.55rem; font-weight: 600; color: #1A3A40; margin-bottom: 14px; transition: color 0.45s ease; }
        .box p { font-size: 1.08rem; color: #555; line-height: 1.7; transition: color 0.45s ease; }
        .box:hover { transform: translateY(-12px); box-shadow: 0 25px 50px rgba(11, 113, 122, 0.15); border-color: #0B717A; }
        .box:hover i { color: #00a3a3; transform: scale(1.18); }
        .box:hover h3 { color: #0B717A; }
        .box:hover p { color: #333; }

        /* About */
        .about-section { padding: 110px 20px; background: linear-gradient(135deg, #f8fdfc 0%, #f0f7f7 100%); text-align: center; }
        .about-section .container { max-width: 1350px; margin: 0 auto; }
        .about-content { display: grid; grid-template-columns: 1fr 1.2fr; gap: 60px; align-items: center; }
        .about-img-wrapper { border-radius: 24px; overflow: hidden; box-shadow: 0 14px 40px rgba(11, 113, 122, 0.14); transition: all 0.45s ease; height: 420px; max-width: 100%; }
        .about-img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.55s ease; }
        .about-img-wrapper:hover { transform: translateY(-8px); box-shadow: 0 25px 55px rgba(11, 113, 122, 0.18); }
        .about-img-wrapper:hover .about-img { transform: scale(1.07); }
        .about-text { text-align: left; }
        .about-text h3 { font-size: 2.1rem; color: var(--primary); margin-bottom: 28px; font-weight: 600; position: relative; padding-left: 32px; }
        .about-text h3::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 5px; height: 38px; background: var(--accent); border-radius: 3px; }
        .about-text p { font-size: 1.15rem; color: #444; line-height: 1.85; margin-bottom: 28px; }
        .about-text ul { list-style: none; padding: 0; margin: 0; }
        .about-text li { display: flex; align-items: flex-start; margin: 18px 0; font-size: 1.14rem; color: #333; line-height: 1.7; transition: all 0.35s ease; }
        .about-text li:hover { color: var(--primary); transform: translateX(6px); }
        .about-text li i { color: #27ae60; font-size: 1.35rem; margin-right: 14px; margin-top: 2px; flex-shrink: 0; }

        /* Why Choose */
        .why-choose { padding: 120px 20px; background: linear-gradient(135deg, #f8fdfc 0%, #f0f7f7 100%); text-align: center; }
        .why-choose .container { max-width: 1400px; margin: 0 auto; }
        .why-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 35px; margin-top: 25px; }
        .why-card { background: white; padding: 45px 28px; border-radius: 26px; text-align: center; box-shadow: 0 14px 40px rgba(11, 113, 122, 0.12); transition: all 0.45s ease; border: 1.5px solid #eef2f6; position: relative; overflow: hidden; }
        .why-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, var(--primary), #00d4d4); transform: scaleX(0); transform-origin: left; transition: transform 0.45s ease; }
        .why-card:hover::before { transform: scaleX(1); }
        .icon-circle { width: 90px; height: 90px; margin: 0 auto 25px; background: linear-gradient(135deg, #0B717A, #00d4d4); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.45s ease; box-shadow: 0 10px 25px rgba(11, 113, 122, 0.22); }
        .why-card:hover .icon-circle { background: var(--accent); transform: translateY(-6px) scale(1.12); box-shadow: 0 14px 30px rgba(255, 107, 107, 0.35); }
        .icon-circle i { font-size: 2.5rem; color: white; }
        .why-card h3 { font-size: 1.55rem; font-weight: 600; color: #1A3A40; margin-bottom: 14px; transition: color 0.45s ease; }
        .why-card p { font-size: 1.08rem; color: #555; line-height: 1.7; transition: color 0.45s ease; }
        .why-card:hover { transform: translateY(-14px); box-shadow: 0 30px 60px rgba(11, 113, 122, 0.18); border-color: var(--primary); }
        .why-card:hover h3 { color: var(--primary); }
        .why-card:hover p { color: #333; }

        /* Doctors */
        .doctors-preview { padding: 140px 20px; background: white; }
        .doctor-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 35px; max-width: 1400px; margin: 70px auto 0; }
        .doctor-card { background: white; border-radius: 28px; overflow: hidden; box-shadow: 0 18px 45px rgba(0,0,0,0.12); transition: 0.65s; }
        .doctor-card img { width: 100%; height: 270px; object-fit: cover; transition: 0.55s; }
        .doctor-info { padding: 28px; text-align: center; }
        .doctor-info h4 { font-size: 1.45rem; color: var(--primary); margin-bottom: 10px; font-weight: 600; }
        .doctor-info p { font-size: 1.05rem; color: #555; line-height: 1.6; }
        .doctor-card:hover img { transform: scale(1.12); }
        .doctor-card:hover { transform: translateY(-18px); box-shadow: 0 30px 60px rgba(0,0,0,0.2); }

        /* Testimonials */
        .testimonials { padding: 120px 20px; background: linear-gradient(135deg, #f0f7f7, #e6f7f7); text-align: center; }
        .testimonials .container { max-width: 1100px; margin: 0 auto; }
        .testimonial-slider { position: relative; overflow: hidden; border-radius: 28px; box-shadow: 0 18px 45px rgba(11, 113, 122, 0.14); background: white; }
        .testimonial-slide { display: none; padding: 55px 45px; animation: fadeIn 0.9s ease; opacity: 0; }
        .testimonial-slide.active { display: block; opacity: 1; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(25px); } to { opacity: 1; transform: translateY(0); } }
        .testimonial-card { max-width: 900px; margin: 0 auto; }
        .quote { font-size: 1.45rem; font-style: italic; color: #333; line-height: 1.9; margin-bottom: 30px; position: relative; padding: 0 15px; }
        .quote::before, .quote::after { content: '"'; font-size: 3.5rem; color: var(--primary); opacity: 0.22; position: absolute; font-family: serif; }
        .quote::before { top: -12px; left: -12px; }
        .quote::after { bottom: -35px; right: -12px; }
        .author { font-weight: 600; color: var(--primary); font-size: 1.2rem; }
        .slider-dots { text-align: center; padding: 25px 0; background: #f8f9fa; }
        .dot { height: 14px; width: 14px; margin: 0 8px; background-color: #bbb; border-radius: 50%; display: inline-block; cursor: pointer; transition: all 0.35s ease; }
        .dot.active, .dot:hover { background-color: var(--primary); transform: scale(1.25); }
        .slider-prev, .slider-next { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(11, 113, 122, 0.75); color: white; border: none; width: 50px; height: 50px; border-radius: 50%; font-size: 1.7rem; cursor: pointer; transition: all 0.35s ease; z-index: 10; }
        .slider-prev { left: 18px; }
        .slider-next { right: 18px; }
        .slider-prev:hover, .slider-next:hover { background: var(--primary); transform: translateY(-50%) scale(1.12); }

        /* Stats */
        .stats { padding: 120px 20px; background: linear-gradient(135deg, var(--secondary), #152a2f); color: white; text-align: center; }
        .stats .container { max-width: 1400px; margin: 0 auto; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 45px; }
        .stat-item { position: relative; padding: 35px 22px; border-radius: 28px; background: rgba(255, 255, 255, 0.09); backdrop-filter: blur(12px); border: 1.5px solid rgba(255, 255, 255, 0.18); transition: all 0.55s ease; overflow: hidden; }
        .stat-item::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, #00d4d4, #ff6b6b); transform: scaleX(0); transition: transform 0.55s ease; }
        .stat-item:hover::before { transform: scaleX(1); }
        .stat-item:hover { transform: translateY(-18px); box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35); background: rgba(255, 255, 255, 0.18); }
        .icon-circle { width: 90px; height: 90px; margin: 0 auto 22px; background: linear-gradient(135deg, #00d4d4, #ff6b6b); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.3rem; color: white; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22); transition: all 0.45s ease; }
        .stat-item:hover .icon-circle { transform: scale(1.12) rotate(6deg); box-shadow: 0 18px 40px rgba(255, 107, 107, 0.45); }
        .stat-item h3 { font-size: 3.6rem; font-weight: 800; margin: 12px 0; color: #fff; }
        .text-stat { font-size: 3.4rem; font-weight: 700; color: #a8e6cf; text-shadow: 0 0 18px rgba(168, 230, 207, 0.7); }
        .stat-item p { font-size: 1.18rem; color: #eee; font-weight: 500; margin: 0; }

        /* Help */
        .help-section { padding: 50px; background: var(--dark); color: white; text-align: center; font-size: 1.3rem; font-weight: 500; }
        .help-section a { color: #a8e6cf; text-decoration: none; font-weight: bold; }

        /* SOS */
        .sos-fixed { position: fixed; bottom: 40px; right: 40px; background: var(--neon-red); color: white; font-weight: bold; font-size: 17px; border: none; border-radius: 50px; padding: 20px 36px; display: flex; align-items: center; gap: 14px; box-shadow: 0 0 40px rgba(255, 23, 68, 0.85); cursor: pointer; z-index: 9999; animation: neonPulse 1.8s infinite alternate; transition: 0.45s; }
        .sos-fixed:hover { background: #d50000; transform: scale(1.14); box-shadow: 0 0 70px rgba(255, 23, 68, 1); }
        @keyframes neonPulse { 0% { box-shadow: 0 0 28px rgba(255, 23, 68, 0.85); } 100% { box-shadow: 0 0 55px rgba(255, 23, 68, 1), 0 0 90px rgba(255, 23, 68, 0.65); } }

        /* Back to Top */
        .back-to-top { position: fixed; bottom: 120px; right: 40px; background: var(--primary); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; cursor: pointer; opacity: 0; visibility: hidden; transition: 0.55s; z-index: 999; box-shadow: 0 10px 28px rgba(0,0,0,0.22); }
        .back-to-top.show { opacity: 1; visibility: visible; bottom: 130px; }
        .back-to-top:hover { background: var(--secondary); transform: translateY(-7px); }

        /* Responsive */
        @media (max-width: 992px) {
            .hero { flex-direction: column; text-align: center; padding: 4rem 2rem; }
            .hero-text { margin-bottom: 2rem; }
            .hero-images { flex-direction: row; justify-content: center; margin-top: 2rem; }
            .boxes, .why-grid { grid-template-columns: repeat(2, 1fr); }
            .about-content { grid-template-columns: 1fr; }
            .about-text { text-align: center; }
            .about-text h3 { padding-left: 0; }
            .about-text h3::before { display: none; }
        }
        @media (max-width: 768px) {
            .boxes, .why-grid { grid-template-columns: 1fr; }
            .mobile-toggle { display: block; }
            .nav-links { position: absolute; top: 100%; left: 0; width: 100%; background: white; flex-direction: column; padding: 1rem 5%; display: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
            .nav-links.active { display: flex; }
        }
        @media (max-width: 576px) {
            .hero h1 { font-size: 2.5rem; }
            .section-title { font-size: 2.8rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Floating Particles & Glow -->
    <div class="particles" id="particles"></div>
    <div class="mouse-glow" id="mouseGlow"></div>

    @include('website.layout.navbar')

    <!-- Scrolling Text -->
    <div class="scrolling-text">
        <span>{{ $hospital_name ?? 'MediCare Hospital' }} — NABH Accredited • 24/7 Emergency & Trauma Center • 200+ Super-Specialists • 50,000+ Successful Surgeries • 15+ Years of Trusted Care • Advanced ICUs, NICU, PICU • Robotic Surgery • In-House Pharmacy & Diagnostics • 500+ Bed Multispecialty Hospital</span>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-text" data-aos="fade-right">
            <span>We Take Care of Your Health</span>
            <h1>We Are Providing Best & Affordable Health Care.</h1>
            <p>Our goal is to deliver the highest quality healthcare services. Everyone deserves access to excellent medical care without compromising on quality.</p>
            <a href="#" class="btn">Read More</a>
           
        </div>
        <div class="hero-images" data-aos="fade-left">
            <img src="{{ asset('assets/image/banner1.jpg') }}" alt="Doctor">
            <img src="{{ asset('assets/image/Banner2.jpg') }}" alt="Nurse">
        </div>
    </section>

    <!-- Health Gateway -->
    <section class="health-gateway" id="services">
        <h2 class="section-title" data-aos="fade-up">Your Health Gateway</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
            Book, consult, test, and get emergency care — all in one place.
        </p>
        <div class="boxes">
            <a href="{{ url('employee-userlogin') }}" class="box" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-calendar-check"></i>
                <h3>Book Appointment</h3>
                <p>200+ specialists. Same-day slots.</p>
            </a>
            <a href="{{ url('employee-userlogin') }}" class="box" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-video"></i>
                <h3>Online Consultation</h3>
                <p>Video call with doctors anytime.</p>
            </a>
            <a href="{{ url('employee-userlogin') }}" class="box" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-vials"></i>
                <h3>Tests & Health Checkup</h3>
                <p>Reports in 24 hours. Home collection.</p>
            </a>
            <a href="{{ url('employee-userlogin') }}" class="box" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-ambulance"></i>
                <h3>Emergency Care</h3>
                <p>24/7 critical support. Zero wait.</p>
            </a>
        </div>
    </section>

    <!-- About -->
    <section class="about-section" id="about">
        <div class="container">
            <h2 class="section-title">Welcome to MediCare Multispecialty Hospital</h2>
            <p class="section-subtitle">
                NABH-accredited 500-bed super-specialty hospital trusted by over 50,000 patients. Equipped with advanced ICUs, modular OTs, robotic surgery systems, and a dedicated team of 200+ expert doctors.
            </p>
            <div class="about-content">
                <div class="about-img-wrapper" data-aos="fade-right">
                    <img src="{{ asset('assets/image/About.jpg') }}" alt="MediCare Hospital Building" class="about-img">
                </div>
                <div class="about-text" data-aos="fade-left">
                    <h3>Why MediCare Stands Apart</h3>
                    <p>Established in 2008, MediCare Hospital has grown into a leading healthcare destination offering comprehensive medical services under one roof.</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i><span>NABH Accredited & ISO 9001:2015 Certified</span></li>
                        <li><i class="fas fa-check-circle"></i><span>15+ Years of Clinical Excellence & Patient Trust</span></li>
                        <li><i class="fas fa-check-circle"></i><span>98.7% Patient Satisfaction Score (Verified)</span></li>
                        <li><i class="fas fa-check-circle"></i><span>Da Vinci Robotic Surgery System for Precision</span></li>
                        <li><i class="fas fa-check-circle"></i><span>50,000+ Successful Surgeries & Procedures</span></li>
                        <li><i class="fas fa-check-circle"></i><span>24/7 Cardiac Cath Lab & Stroke Unit</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose -->
    <section class="why-choose">
        <div class="container">
            <h2 class="section-title">Why Patients Choose MediCare</h2>
            <p class="section-subtitle">We combine medical expertise, cutting-edge technology, and compassionate care to deliver outcomes that matter — every single time.</p>
            <div class="why-grid">
                <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-circle"><i class="fas fa-user-md"></i></div>
                    <h3>200+ Expert Doctors</h3>
                    <p>Board-certified super-specialists with 15–30 years of experience.</p>
                </div>
                <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-circle"><i class="fas fa-clock"></i></div>
                    <h3>24/7 Critical Care</h3>
                    <p>Fully equipped Emergency Department, Level-1 Trauma Center.</p>
                </div>
                <div class="why-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-circle"><i class="fas fa-microscope"></i></div>
                    <h3>Advanced Technology</h3>
                    <p>128-Slice CT, 3T MRI, Digital X-Ray, Cath Labs, Robotic Surgery.</p>
                </div>
                <div class="why-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon-circle"><i class="fas fa-heart"></i></div>
                    <h3>Patient-Centric Care</h3>
                    <p>Personalized treatment plans, dedicated care coordinators.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors -->
    <section class="doctors-preview" id="doctors">
        <h2 class="section-title">Meet Our Super-Specialists</h2>
        <div class="doctor-grid">
            <div class="doctor-card" data-aos="zoom-in"><img src="{{ asset('assets/image/doctor-01.jpg') }}" alt="Dr. A. Sharma"><div class="doctor-info"><h4>Dr. A. Sharma</h4><p>Chief Cardiologist | 18+ yrs | 5,000+ Angiographies</p></div></div>
            <div class="doctor-card" data-aos="zoom-in" data-aos-delay="100"><img src="{{ asset('assets/image/doctor-02.jpg') }}" alt="Dr. R. Verma"><div class="doctor-info"><h4>Dr. R. Verma</h4><p>Senior Neurologist | 15+ yrs</p></div></div>
            <div class="doctor-card" data-aos="zoom-in" data-aos-delay="200"><img src="{{ asset('assets/image/doctor-07.jpg') }}" alt="Dr. S. Gupta"><div class="doctor-info"><h4>Dr. S. Gupta</h4><p>Pediatric Surgeon | 12+ yrs</p></div></div>
            <div class="doctor-card" data-aos="zoom-in" data-aos-delay="300"><img src="{{ asset('assets/image/doctor-10.jpg') }}" alt="Dr. K. Patel"><div class="doctor-info"><h4>Dr. K. Patel</h4><p>Orthopedic Surgeon | 20+ yrs</p></div></div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title">Real Patient Stories</h2>
            <p class="section-subtitle">Hear from those whose lives were transformed through timely, expert care at MediCare Hospital.</p>
            <div class="testimonial-slider">
                <div class="testimonial-slide active">
                    <div class="testimonial-card">
                        <p class="quote">"My father had a massive heart attack. The MediCare team responded within 8 minutes, performed emergency angioplasty, and saved his life."</p>
                        <p class="author">— Mr. Rajesh Kumar, Delhi</p>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <p class="quote">"My premature baby was in NICU for 45 days. The pediatric team treated her like family."</p>
                        <p class="author">— Mrs. Priya Singh, Mumbai</p>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <p class="quote">"Robotic knee replacement changed my life. Minimal pain, walked the next day."</p>
                        <p class="author">— Mr. Amit Desai, Pune</p>
                    </div>
                </div>
                <div class="slider-dots">
                    <span class="dot active" onclick="currentSlide(0)"></span>
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                </div>
                <button class="slider-prev" onclick="plusSlides(-1)"><</button>
                <button class="slider-next" onclick="plusSlides(1)">></button>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-target="50000">
                    <div class="icon-circle"><i class="fas fa-smile"></i></div>
                    <h3><span class="count">0</span>+</h3>
                    <p>Happy Patients Treated</p>
                </div>
                <div class="stat-item" data-target="200">
                    <div class="icon-circle"><i class="fas fa-user-md"></i></div>
                    <h3><span class="count">0</span>+</h3>
                    <p>Super-Specialist Doctors</p>
                </div>
                <div class="stat-item" data-type="text" data-text="24/7">
                    <div class="icon-circle"><i class="fas fa-clock"></i></div>
                    <h3 class="text-stat">24/7</h3>
                    <p>Emergency & ICU Services</p>
                </div>
                <div class="stat-item" data-target="15">
                    <div class="icon-circle"><i class="fas fa-calendar-alt"></i></div>
                    <h3><span class="count">0</span>+</h3>
                    <p>Years of Trusted Healthcare</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Help -->
    @include('website.layout.footer')

    <!-- SOS & Back to Top -->
    <button class="sos-fixed" onclick="alert('EMERGENCY DISPATCHED! Ambulance en route...')">
        <i class="fas fa-exclamation-triangle"></i> SOS EMERGENCY
    </button>
    <div class="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1200, once: true });

        // Particles
        const particles = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.width = p.style.height = Math.random() * 12 + 6 + 'px';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 20 + 's';
            p.style.animationDuration = Math.random() * 18 + 18 + 's';
            particles.appendChild(p);
        }

        // Mouse Glow
        const glow = document.getElementById('mouseGlow');
        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });

        // Mobile Menu
        const toggle = document.getElementById('mobileToggle');
        const links = document.getElementById('navLinks');
        if (toggle && links) {
            toggle.onclick = () => {
                links.classList.toggle('active');
                toggle.querySelector('i').classList.toggle('fa-bars');
                toggle.querySelector('i').classList.toggle('fa-times');
            };
        }

        // Testimonial Slider
        let slideIndex = 0;
        const slides = document.querySelectorAll('.testimonial-slide');
        const dots = document.querySelectorAll('.dot');
        function showSlides(n) {
            if (n >= slides.length) slideIndex = 0;
            if (n < 0) slideIndex = slides.length - 1;
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            slides[slideIndex].classList.add('active');
            dots[slideIndex].classList.add('active');
        }
        function plusSlides(n) { slideIndex += n; showSlides(slideIndex); }
        function currentSlide(n) { slideIndex = n; showSlides(slideIndex); }
        let autoSlide = setInterval(() => plusSlides(1), 6000);
        document.querySelector('.testimonial-slider').addEventListener('mouseenter', () => clearInterval(autoSlide));
        document.querySelector('.testimonial-slider').addEventListener('mouseleave', () => autoSlide = setInterval(() => plusSlides(1), 6000));
        showSlides(slideIndex);

        // Stats Counter
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.count');
            const speed = 95;
            const startCounting = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.closest('.stat-item').getAttribute('data-target');
                        const increment = target / speed;
                        let count = 0;
                        const updateCount = () => {
                            if (count < target) {
                                count += increment;
                                counter.textContent = Math.ceil(count);
                                requestAnimationFrame(updateCount);
                            } else {
                                counter.textContent = target;
                            }
                        };
                        updateCount();
                        observer.unobserve(counter);
                    }
                });
            };
            const observer = new IntersectionObserver(startCounting, { threshold: 0.7 });
            counters.forEach(c => observer.observe(c));
        });

        // Back to Top
        const backToTop = document.querySelector('.back-to-top');
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('show', window.scrollY > 600);
        });
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
