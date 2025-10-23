<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome | Hospital CRM</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ $logo }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

  <style>
    :root {
      --primary: #0B717A;
      --light: #E8F9F9;
      --gradient: linear-gradient(135deg, #0B717A, #0DD1C0);
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #e7fbfb, #f5ffff);
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    /* Animations */
    @keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-8px);} }
    @keyframes fadeIn { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }

    .fade-in { animation: fadeIn 1.5s ease forwards; opacity: 0; }
    .float { animation: float 4s ease-in-out infinite; }

    /* Glass & Navbar */
    .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(14px); border: 1px solid rgba(255,255,255,0.3); }
    .navbar { background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); position: fixed; top:0;left:0;right:0; z-index:50; transition: all 0.3s ease; }
    .navbar.scrolled { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

    /* Section Titles */
    h2.section-title { @apply text-3xl font-semibold text-[var(--primary)] mb-6; }
  </style>
</head>

<body class="text-gray-800">

  <!-- 🔹 NAVBAR -->
  <header id="navbar" class="navbar flex justify-between items-center px-8 py-4">
    <div class="flex items-center gap-3">
      <i class="fa-solid fa-hospital text-[var(--primary)] text-3xl"></i>
      <h1 class="font-semibold text-xl text-[var(--primary)]">My Hospital CRM</h1>
    </div>
    <a href="{{ route('admin.login.form') }}" class="bg-[var(--primary)] text-white px-6 py-2 rounded-full shadow hover:bg-[#095f68] transition-all">
      Go to Dashboard →
    </a>
  </header>

  <!-- 🔹 HERO SECTION -->
  <section class="min-h-screen flex flex-col items-center justify-center text-center px-6 bg-gradient-to-br from-[#d9f9f9] to-white relative overflow-hidden">
    <!-- wave background -->
    <svg class="absolute bottom-0 left-0 w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250"><path fill="#0B717A22" fill-opacity="1" d="M0,192L80,176C160,160,320,128,480,117.3C640,107,800,117,960,122.7C1120,128,1280,128,1360,128L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>

    <div class="fade-in max-w-4xl mt-24 relative z-10">
      <div class="mb-8">
        <div class="bg-[var(--primary)] inline-block p-6 rounded-full float shadow-xl">
          <i class="fa-solid fa-heart-pulse text-white text-5xl"></i>
        </div>
      </div>

      <h1 class="text-5xl md:text-6xl font-bold text-[var(--primary)] mb-4">Welcome to Our Hospital CRM</h1>
      <p class="text-gray-600 text-lg md:text-xl leading-relaxed mb-4">
        A powerful, intuitive, and secure system designed to simplify hospital management, enhance patient care, 
        and connect your medical team like never before.
      </p>
      <p class="text-[var(--primary)] font-medium text-lg italic mb-8">"Empowering Hospitals. Enhancing Care."</p>

      <a href="#features" class="bg-[var(--primary)] text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:bg-[#095f68] hover:scale-105 transition-all duration-300">
        Explore Features ↓
      </a>
    </div>
  </section>

  <!-- 🔹 ABOUT SECTION -->
  <section class="py-20 px-8 bg-white">
    <div class="max-w-5xl mx-auto text-center">
      <h2 class="section-title">What is Hospital CRM?</h2>
      <p class="text-gray-600 text-lg leading-relaxed">
        Hospital CRM is your all-in-one healthcare management ecosystem that empowers doctors, nurses, and administrators 
        to deliver seamless patient experiences. It brings together patient data, appointments, billing, communication, and analytics 
        under one unified and secure platform.
      </p>
    </div>
  </section>

  <!-- 🔹 FEATURES SECTION -->
  <section id="features" class="py-20 bg-[var(--light)]">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-[var(--primary)] mb-12">Core Features</h2>

      <div class="grid md:grid-cols-3 gap-10">
        <div class="glass p-8 rounded-2xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
          <i class="fa-solid fa-users text-[var(--primary)] text-4xl mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Patient Management</h3>
          <p class="text-gray-600 text-sm">Centralized dashboard for managing patient details, reports, and medical records with complete security.</p>
        </div>

        <div class="glass p-8 rounded-2xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
          <i class="fa-solid fa-user-md text-[var(--primary)] text-4xl mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Doctor & Staff Coordination</h3>
          <p class="text-gray-600 text-sm">Streamline scheduling, duty allocation, and team communication across departments efficiently.</p>
        </div>

        <div class="glass p-8 rounded-2xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
          <i class="fa-solid fa-chart-line text-[var(--primary)] text-4xl mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Data Analytics</h3>
          <p class="text-gray-600 text-sm">Access real-time analytics to make data-driven decisions for improved operational efficiency.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 🔹 CONTACT SECTION -->
  <section class="py-20 bg-white text-center">
    <h2 class="text-3xl font-semibold text-[var(--primary)] mb-4">Need Support?</h2>
    <p class="text-gray-600 mb-10">We’re here to help with setup, onboarding, or technical guidance anytime.</p>

    <div class="flex flex-col md:flex-row justify-center gap-10 items-center">
      <div class="glass p-6 rounded-2xl w-72 text-center shadow hover:shadow-lg transition">
        <i class="fa-solid fa-envelope text-[var(--primary)] text-4xl mb-3"></i>
        <h3 class="text-lg font-semibold text-gray-700 mb-1">Email Us</h3>
        <p class="text-gray-600 text-sm mb-3">Get support via mail within 24 hours</p>
        <a href="mailto:support@myhospitalcrm.com" 
           class="bg-[var(--primary)] text-white px-5 py-2 rounded-full text-sm hover:bg-[#095f68] transition">
          support@myhospitalcrm.com
        </a>
      </div>

      <div class="glass p-6 rounded-2xl w-72 text-center shadow hover:shadow-lg transition">
        <i class="fa-solid fa-phone text-[var(--primary)] text-4xl mb-3"></i>
        <h3 class="text-lg font-semibold text-gray-700 mb-1">Call Support</h3>
        <p class="text-gray-600 text-sm mb-3">Mon–Sat, 9AM to 6PM</p>
        <a href="tel:+918765432109" 
           class="bg-[var(--primary)] text-white px-5 py-2 rounded-full text-sm hover:bg-[#095f68] transition">
          +91 87654 32109
        </a>
      </div>
    </div>
  </section>

  <!-- 🔹 FOOTER -->
  <footer class="bg-[var(--primary)] text-white py-6 text-center">
    <div class="flex justify-center gap-5 mb-3 text-lg">
      <i class="fa-brands fa-facebook hover:text-gray-200 cursor-pointer"></i>
      <i class="fa-brands fa-twitter hover:text-gray-200 cursor-pointer"></i>
      <i class="fa-brands fa-linkedin hover:text-gray-200 cursor-pointer"></i>
      <i class="fa-brands fa-instagram hover:text-gray-200 cursor-pointer"></i>
    </div>
    <p class="text-sm">&copy; 2025 My Hospital CRM | Built with ❤️ for Smarter Healthcare</p>
  </footer>

  <script>
    // Navbar scroll shadow
    window.addEventListener("scroll", () => {
      const navbar = document.getElementById("navbar");
      navbar.classList.toggle("scrolled", window.scrollY > 10);
    });
  </script>
</body>
</html>