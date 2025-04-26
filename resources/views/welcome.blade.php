<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/ssdc_favicon.png') }}" type="image/png">
    <title>SSDC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: url('{{ asset('img/ssdc_bg.jpg') }}') no-repeat center center fixed;
    background-size: cover;
    color: #333;
    scroll-behavior: smooth;
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

header {
    position: relative;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    animation: slideInFromTop 0.8s ease-out;
}

@keyframes slideInFromTop {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Navigation Bar */
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 45px;
    background-color: rgba(255, 255, 255, 0.95);
    box-shadow: 0 1.8px 4.5px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    animation: fadeIn 1s ease-in-out;
}

nav img {
    height: 54px;
    cursor: pointer;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 36px;
    margin-right: 18px;
}

nav ul li {
    display: inline;
}

nav ul li a {
    text-decoration: none;
    color: #333;
    font-size: 15.4px;
    font-weight: 500;
    padding: 9px 13.5px;
    transition: background-color 0.3s ease, color 0.3s ease;
    border-radius: 9px;
}

nav ul li a:hover {
    background-color: #007BFF;
    color: #fff;
    border-radius: 9px;
}

.btn-nav {
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    padding: 10.8px 27px;
    font-size: 14.4px;
    font-weight: 600;
    border-radius: 9px;
    transition: background-color 0.3s ease;
    margin-right: -18px;
}

.btn-nav:hover {
    background-color: #0056b3;
}

/* Hamburger Menu */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 4.5px;
    cursor: pointer;
}

.hamburger div {
    width: 27px;
    height: 3.6px;
    background-color: #333;
    border-radius: 4.5px;
}

.menu {
    display: flex;
    justify-content: flex-end;
    gap: 18px;
}

.menu.active {
    display: flex;
    position: absolute;
    top: 54px;
    right: 18px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 7.2px;
    padding: 13.5px;
    flex-direction: column;
    width: 180px;
}

.menu li a {
    padding: 9px;
    text-align: right;
    border-radius: 4.5px;
}

/* Hero Section */
.hero {
    position: relative;
    top: 45px;
    text-align: center;
    color: white;
    text-shadow: 1.8px 1.8px 4.5px rgba(0, 0, 0, 0.8);
    margin-top: 108px;
    padding: 0 18px;
    animation: slideInFromTop 0.8s ease-out;
}

.hero h1 {
    font-size: 3.4rem;
    font-weight: 700;
    margin-bottom: 18px;
}

.hero p {
    font-size: 1.2rem;
    font-weight: 300;
    margin-bottom: 36px;
}

.btn-hero {
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    padding: 13.5px 36px;
    font-size: 16.2px;
    font-weight: 600;
    border-radius: 9px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-hero:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Contact Info */
.contact-info {
    text-align: center;
    font-size: 1.08rem;
    font-weight: 500;
    margin-bottom: 18px;
    color: rgb(44, 41, 41);
    animation: fadeIn 1.5s ease-out;
}

/* Scroll to Top Button */
.scroll-to-top {
    position: fixed;
    bottom: 18px;
    right: 18px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 45%;
    padding: 13.5px;
    font-size: 16.2px;
    cursor: pointer;
    display: none;
    transition: background-color 0.3s ease;
}

.scroll-to-top:hover {
    background-color: #0056b3;
}

        
    
        /* Sections */
        section {
            padding: 72px 18px;
            text-align: center;
        }
    
        section h2 {
            font-size: 2.7rem;
            font-weight: 600;
            margin-bottom: 18px;
        }
    
        section p {
            font-size: 1.125rem;
            margin-bottom: 18px;
        }
    
        
        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                padding: 13.5px 18px;
            }
    
            nav ul {
                display: none;
            }
    
            .hamburger {
                display: flex;
            }
    
            .menu {
                display: none;
                flex-direction: column;
                align-items: flex-end;
                gap: 9px;
                position: absolute;
                top: 63px;
                right: 18px;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 9px;
                border-radius: 4.5px;
            }
    
            .menu.active {
                display: flex;
            }
    
            .hero {
                margin-top: 144px;
            }
    
            .hero h1 {
                font-size: 2.25rem;
            }
    
            .hero p {
                font-size: 1.08rem;
            }
    
            .btn-hero {
                padding: 10.8px 22.5px;
                font-size: 14.4px;
            }
    
            .contact-info {
                font-size: 0.9rem;
            }
    
            .btn-nav {
                display: none;
            }
        }
    
        /* For large screen */
        @media (min-width: 769px) {
            nav ul {
                margin-left: auto;
                gap: 36px;
            }
    
            .btn-nav {
                display: inline-block;
            }
        }
    </style>
    
</head>
<body>
    <header>
        <!-- Navigation Bar -->
        <nav>
            <img src="{{ asset('img/ssdc_favicon.png') }}" alt="Clinic Logo" style="width: 50px !important; height: 50px !important; filter: brightness(0) invert(0);">
            &nbsp;&nbsp;
            <div style="font-size: 2rem; font-weight: 700; margin-bottom: 0px;">SSDC</div>
            &nbsp;&nbsp;
            
            
            <!-- Hamburger Menu Icon -->
            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <!-- Menu Items -->
            <ul class="menu">
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
            </ul>

            <!-- Request Appointment Button (visible only on PC) -->
            <a href="{{ route('login') }}" class="btn-nav" style="background-color: #3A3F6B;">Log in</a>
        </nav>

        <!-- Hero Section -->
        <div class="hero">
            <h1>Smile Space Dental Clinic</h1>
        
            <a href="{{ route('login') }}" class="btn-hero" style="background-color: #3A3F6B;">Request Appointment</a>
        </div>

        <div class="contact-info">
            <p>
                <span style="font-size: 15px; font-weight: 500;">Contact us at: </span>
                <span style="font-size: 17px; font-weight: 600;">(+63) 916-347-3711</span>
                <span style="font-size: 15px; font-weight: 500;"> &nbsp; |  &nbsp; Email: </span>
                <span style="font-size: 17px; font-weight: 600;">smilespacedentalclinic@gmail.com</span>
              </p>
              
        </div>
    </header>

    <!-- About Section -->
    <section id="about">
        <h2>About Us</h2>
        <p>We are a trusted dental clinic providing high-quality care to our patients. Our team of professionals is committed to offering top-notch dental services to keep your smile bright and healthy.</p>
    </section>

    <!-- Services Section -->
    <section id="services">
        <h2>Our Services</h2>
        <p>We offer a variety of dental services, including routine check-ups, teeth whitening, orthodontics, and more. Our goal is to help you maintain a healthy and beautiful smile.</p>
    </section>

  

   
    
       <!-- Scroll to Top Button -->
       <button id="scrollToTopBtn" class="scroll-to-top" onclick="scrollToTop()">↑</button>

       <footer style="text-align: center; padding: 20px; background-color: #333; color: white; font-size: 15px; position: absolute; bottom: 100; width: 100%; height: 145px;">
        <p style="position: relative; top: 30px;">&copy; 2025 SSDC. All Rights Reserved.</p>
        <p><a href="#" style="color: #fff; text-decoration: none; position: relative; top: 30px;">Privacy Policy &nbsp;&nbsp;|&nbsp;&nbsp;</a>  <a href="#" style="color: #fff; text-decoration: none; position: relative; top: 30px;">Terms of Service</a></p>
    </footer>
    
    
    <script>
        // Toggle menu visibility on mobile
        function toggleMenu() {
            const menu = document.querySelector('.menu');
            menu.classList.toggle('active');
        }

        // Scroll to Top button functionality
        window.onscroll = function() {
            toggleScrollButton();
        };

        function toggleScrollButton() {
            const scrollToTopBtn = document.getElementById("scrollToTopBtn");
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>

