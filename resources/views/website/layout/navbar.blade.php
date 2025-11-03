  <style>
    :root {
      --primary: #0b717a;
      --secondary: #0dcaf0;
      --gradient: linear-gradient(135deg, #0b717a 0%, #0dcaf0 100%);
      --bg-glass: rgba(255, 255, 255, 0.75);
      --radius: 50px;
      --transition: all 0.35s ease;
      --shadow: 0 6px 25px rgba(11, 113, 122, 0.25);
    }

    * {margin:0; padding:0; box-sizing:border-box;}
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(180deg, #f8feff 0%, #e5f8fa 100%);
      min-height: 100vh;
    }

    /* === NAVBAR === */
    nav.navbar {
      position: sticky;
      top: 0;
      width: 100%;
      background: var(--bg-glass);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(11, 113, 122, 0.1);
      box-shadow: var(--shadow);
      transition: var(--transition);
      z-index: 1000;
    }
    nav.navbar.scrolled {
      background: rgba(255,255,255,0.95);
      border-bottom: 2px solid #0dcaf0;
      box-shadow: 0 4px 30px rgba(11,113,122,0.2);
    }

    .nav-container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 2rem;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: height .3s ease;
    }
    nav.navbar.scrolled .nav-container { height:75px; }

    /* === LOGO === */
    .logo {
      display:flex; align-items:center;
      font-size:2.1rem; font-weight:700;
      text-decoration:none;
      background:var(--gradient);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      gap:8px; transition:var(--transition);
    }
    .logo i {color:var(--secondary); font-size:1.8rem;}
    .logo:hover {transform:scale(1.05); filter:drop-shadow(0 0 8px rgba(11,113,122,0.4));}

    /* === LINKS === */
    .nav-links {display:flex; align-items:center; gap:2.2rem;}
    .nav-links a {
      position:relative;
      text-decoration:none;
      color:#1a202c;
      font-weight:500;
      font-size:1rem;
      transition:var(--transition);
    }
    .nav-links a::after {
      content:""; position:absolute; bottom:-6px; left:50%;
      transform:translateX(-50%) scaleX(0);
      width:60%; height:3px; background:var(--gradient);
      border-radius:2px; transition:transform .35s ease;
    }
    .nav-links a:hover {color:var(--primary); transform:translateY(-2px);}
    .nav-links a:hover::after, .nav-links a.active::after {transform:translateX(-50%) scaleX(1);}
    .nav-links a.active {color:var(--primary); font-weight:600;}

    /* === ACTIONS === */
    .user-actions {display:flex; align-items:center; gap:1.2rem;}

    /* Bell + Dropdown */
    .notification-bell {
      position:relative;
      font-size:1.5rem;
      color:#1a202c;
      cursor:pointer;
      transition:var(--transition);
    }
    .notification-bell:hover {
      color:var(--secondary);
      transform:rotate(-10deg) scale(1.1);
      text-shadow:0 0 10px rgba(13,202,240,.5);
    }
    .notification-badge {
      position:absolute; top:-6px; right:-8px;
      background:#ff4757; color:white;
      font-size:0.65rem; font-weight:bold;
      width:18px; height:18px;
      border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      box-shadow:0 0 5px rgba(255,71,87,0.5);
    }

    /* === Notification Dropdown === */
    .notification-dropdown {
      position:absolute;
      top:45px; right:0;
      background:rgba(255,255,255,0.95);
      backdrop-filter:blur(12px);
      border:1px solid rgba(11,113,122,0.15);
      box-shadow:0 8px 25px rgba(11,113,122,0.15);
      border-radius:16px;
      width:260px;
      display:none;
      flex-direction:column;
      overflow:hidden;
      animation:fadeIn .3s ease;
    }
    .notification-dropdown.active {display:flex;}
    .notification-dropdown p {
      padding:12px 15px;
      border-bottom:1px solid #eee;
      font-size:0.9rem;
      color:#333;
      display:flex;
      align-items:center;
      gap:10px;
      transition:var(--transition);
    }
    .notification-dropdown p:last-child {border-bottom:none;}
    .notification-dropdown p:hover {
      background:rgba(13,202,240,0.08);
      color:var(--primary);
      transform:translateX(5px);
    }
    .notification-dropdown i {
      color:var(--secondary);
    }
    @keyframes fadeIn {
      from {opacity:0; transform:translateY(-10px);}
      to {opacity:1; transform:translateY(0);}
    }

    /* === BUTTONS === */
    .btn-appointment {
      background:var(--gradient);
      color:white;
      border:none;
      padding:.65rem 1.5rem;
      border-radius:var(--radius);
      font-weight:600;
      font-size:.95rem;
      cursor:pointer;
      transition:var(--transition);
      box-shadow:0 4px 20px rgba(13,202,240,0.35);
    }
    .btn-appointment:hover {
      transform:translateY(-3px);
      box-shadow:0 8px 25px rgba(13,202,240,0.45);
    }

    .btn-login {
      background:transparent;
      border:2px solid var(--primary);
      color:var(--primary);
      padding:.55rem 1.3rem;
      border-radius:var(--radius);
      font-weight:600;
      font-size:.92rem;
      cursor:pointer;
      transition:var(--transition);
    }
    .btn-login:hover {
      background:var(--primary);
      color:white;
      box-shadow:0 5px 18px rgba(11,113,122,0.35);
      transform:translateY(-2px);
    }

    /* === MOBILE === */
    .mobile-toggle {
      display:none;
      font-size:1.9rem;
      cursor:pointer;
      color:var(--primary);
      transition:var(--transition);
    }
    @media (max-width:992px) {
      .nav-links {
        position:absolute; top:100%; left:0; right:0;
        flex-direction:column;
        background:rgba(255,255,255,0.95);
        backdrop-filter:blur(15px);
        border-radius:0 0 20px 20px;
        box-shadow:0 10px 25px rgba(11,113,122,0.2);
        padding:1.5rem 0;
        opacity:0; pointer-events:none;
        transform:translateY(-15px);
        transition:var(--transition);
      }
      .nav-links.active {
        opacity:1; pointer-events:auto; transform:translateY(0);
      }
      .mobile-toggle {display:block;}
      .user-actions {display:none;}
    }
  </style>
</head>
<body>

  <nav class="navbar" id="navbar">
    <div class="nav-container">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="logo">
            <img class="logo-icon" src="{{ $logo ?? asset('assets/image/logo.png') }}" alt="{{ $hospital_name ?? 'MediCare Hospital' }} Logo">
            <span>{{ $hospital_name ?? 'MediCare Hospital' }}</span>
        </a>

      <!-- Links -->
      <div class="nav-links" id="navLinks">
        <a href="index.html" class="active"><i class="fa-solid fa-house"></i> Home</a>
        <a href="employee-userlogin.html"><i class="fa-solid fa-file-medical"></i> Reports</a>
        <a href="employee-userlogin.html"><i class="fa-solid fa-user"></i> Profile</a>
      </div>

      <!-- User Actions -->
      <div class="user-actions">
        <div class="notification-bell" id="notificationBell">
          <i class="fa-solid fa-bell"></i>
          <span class="notification-badge" id="notifBadge">3</span>
          <div class="notification-dropdown" id="notifDropdown">
            <p><i class="fa-solid fa-file-medical"></i> New report added</p>
            <p><i class="fa-solid fa-calendar-check"></i> Appointment tomorrow</p>
            <p><i class="fa-solid fa-user-md"></i> Doctor updated schedule</p>
          </div>
        </div>

        <!-- Sign Up Button -->
        <button class="btn-appointment" id="signupBtn">
          <i class="fa-solid fa-user-plus"></i> Sign Up
        </button>

        <!-- Login Button -->
        <button class="btn-login" id="loginBtn">
          <i class="fa-solid fa-right-to-bracket"></i> Login
        </button>
      </div>

      <div class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </nav>

<script>
  const navbar = document.getElementById("navbar");
  window.addEventListener("scroll", () => navbar.classList.toggle("scrolled", window.scrollY > 80));

  const mobileToggle = document.getElementById("mobileToggle");
  const navLinks = document.getElementById("navLinks");
  mobileToggle.addEventListener("click", () => {
    navLinks.classList.toggle("active");
    const icon = mobileToggle.querySelector("i");
    icon.classList.toggle("fa-bars");
    icon.classList.toggle("fa-times");
  });

  // Sign Up Link
  document.getElementById("signupBtn").onclick = () => location.href = "register.html";

  // Login Link
  document.getElementById("loginBtn").onclick = () => location.href = "{{ route('login.selection') }}";

  // Notifications
  const notificationBell = document.getElementById("notificationBell");
  const notifDropdown = document.getElementById("notifDropdown");

  notificationBell.addEventListener("click", (e) => {
    e.stopPropagation();
    notifDropdown.classList.toggle("active");
  });

  document.addEventListener("click", () => notifDropdown.classList.remove("active"));
</script>
