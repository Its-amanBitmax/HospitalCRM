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

    .footer {
      position: relative;
      width: 100%;
      background: var(--bg-glass);
      backdrop-filter: blur(18px);
      border-top: 1px solid rgba(11, 113, 122, 0.1);
      box-shadow: var(--shadow);
      transition: var(--transition);
      z-index: 1000;
      padding: 50px 0;
    }

    .footer .container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .footer-col h3, .footer-col h4 {
      color: var(--primary);
      margin-bottom: 1rem;
      font-weight: 600;
    }

    .footer-col p, .footer-col a {
      color: #333;
      text-decoration: none;
      margin-bottom: 0.5rem;
      transition: var(--transition);
    }

    .footer-col a:hover {
      color: var(--secondary);
      transform: translateX(5px);
    }

    .social {
      display: flex;
      gap: 1rem;
    }

    .social a {
      color: var(--primary);
      font-size: 1.5rem;
      transition: var(--transition);
    }

    .social a:hover {
      color: var(--secondary);
      transform: scale(1.2);
    }

    .footer-bottom {
      text-align: center;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 1px solid rgba(11, 113, 122, 0.1);
      color: #666;
    }
</style>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>{{ $hospital_name ?? 'MediCare' }} Hospital</h3>
                <p>NABH Accredited • 500+ Beds • 200+ Specialists</p>
                <p>24/7 Emergency • Advanced ICUs • Robotic Surgery</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="#">Book Appointment</a>
                <a href="#">Online Consultation</a>
                <a href="#">Health Checkup</a>
                <a href="#">Emergency Care</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone"></i> {{ $company_contact ?? '9876543210' }}</p>
                <p><i class="fas fa-envelope"></i> {{ $company_email ?? 'care@medicarehospital.com' }}</p>
                <p><i class="fas fa-map-marker-alt"></i> {{ $company_address ?? 'Delhi, India' }}</p>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} {{ $hospital_name ?? 'MediCare' }} Hospital. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- SOS & Back to Top -->
<button class="sos-fixed" onclick="alert('EMERGENCY DISPATCHED! Ambulance en route...')">
    <i class="fas fa-exclamation-triangle"></i> SOS EMERGENCY
</button>
<div class="back-to-top" onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
</div>