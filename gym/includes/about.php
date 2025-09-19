<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FitZone</title>
    <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
    <link rel="stylesheet" href="../styles/aboutus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow-x: hidden;
            background-color: #000;
            
        }

        header {
            width: 100%;
            background-color: #000;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .logo {
            width: 120px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        .nav-links li a {
            color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: #e63946;
        }

        .section {
            height: 100vh;
            padding: 100px 30px 60px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-direction: column;
            text-align: center;
        }

        @media (min-width: 768px) {
            .section {
                flex-direction: row;
                text-align: left;
                justify-content: space-between;
            }

            .text-right {
                margin-left: auto;
                text-align: right;
                max-width: 600px;
                padding-left: 20px;
            }
        }

        @media (max-width: 480px) {
            .section h1,
            .section h2 {
                font-size: 32px;
            }

            .section p {
                font-size: 16px;
            }
        }

        .bg-imageWc {
            background: url('image/bg-imagewc.png') no-repeat center center/cover;
            
        }

        .bg-imageVm {
            background: url('image/bg-imagevm.png') no-repeat center center/cover;
        }

        .bg-imageOf {
            background: url('image/bg-imageof.png') no-repeat center center/cover;
        }

        .section h1,
        .section h2 {
            font-size: 48px;
            line-height: 1.2;
            color:#e63946;
        }

        .section p {
            max-width: 600px;
            margin-top: 20px;
            font-size: 18px;
        }

        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #e63946;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #d62828;
        }

        .slide-in {
            opacity: 0;
            transform: translateY(100px);
            transition: all 0.8s ease-out;
        }

        .slide-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <header>
        <img src="image/logo.png" alt="FitZone Logo" class="logo">
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a class="active" href="about.php">About</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="membership.php">Membership</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>

    <!-- Page 1 - Welcome Section -->
    <section class="section bg-imageWc">
        <div>
            <h1><span>WELCOME TO</span><br>FITZONE CLUB</h1>
            <p>Kickstart your fitness journey with state-of-the-art equipment and elite trainers by your side <br> & <br>all customized to match your unique goals and lifestyle. Let’s achieve greatness together!</p>
        </div>
    </section>

    <!-- Page 2 - Vision & Mission -->
    <section class="section bg-imageVm slide-in">
        <div class="text-right">
            <h2><span>OUR VISION &</span><br>MISSION</h2>
            <p><strong>Vision:</strong> To be the leading hub of fitness excellence and transformation.</p>
            <p><strong>Mission:</strong> Empower individuals to achieve their fitness goals through innovation, dedication, and passion.</p>
        </div>
    </section>

    <!-- Page 3 - Our Facilities -->
    <section class="section bg-imageOf slide-in">
        <div>
            <h2><span>OUR</span><br>FACILITIES</h2>
            <p>FitZone offers the latest fitness equipment, expert-led classes, spacious workout zones, clean changing rooms, and a refreshing health bar — all designed to make your fitness journey smooth, fun, and effective.</p>
            <a href="register.php" class="cta-button">GET STARTED</a>
        </div>
    </section>

    <script>
        const sections = document.querySelectorAll('.slide-in');
        const options = { threshold: 0.1 };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        sections.forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>
