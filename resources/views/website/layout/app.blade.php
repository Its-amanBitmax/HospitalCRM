<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'MediCare Hospital | Excellence in Healthcare')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ Auth::guard('admin')->user() && Auth::guard('admin')->user()->logo ? asset('storage/' . Auth::guard('admin')->user()->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Floating Particles & Glow -->
    <div class="particles" id="particles"></div>
    <div class="mouse-glow" id="mouseGlow"></div>

    @include('website.layout.navbar')

    @yield('content')

    @include('website.layout.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    @stack('scripts')
</body>
</html>