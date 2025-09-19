<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FitZone Fitness Center</title>
  <link rel="icon" type="image/x-icon" href="includes/image/icons/sicon.ico">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: black;
      padding: 10px 20px;
      flex-wrap: wrap;
    }

    .logo img {
      height: 50px;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 20px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav ul li a:hover {
      color: red;
    }

    .search-bar form {
      display: flex;
      align-items: center;
      background: white;
      border-radius: 5px;
      overflow: hidden;
    }

    .search-bar input[type="text"] {
      padding: 8px 10px;
      border: none;
      outline: none;
      width: 200px;
    }

    .search-bar button {
      background-color: red;
      border: none;
      padding: 8px 12px;
      cursor: pointer;
    }

    .search-bar button i {
      color: white;
    }

    .hero {
      background: url('includes/image/bg-image1.png') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 0 20px;
    }

    .hero h1 {
      font-size: 3rem;
      text-shadow: 2px 2px 5px #000;
      margin-bottom: 30px;
    }

    .join-btn {
      background-color: red;
      color: white;
      padding: 15px 30px;
      border: none;
      font-size: 1.2rem;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .join-btn:hover {
      background-color: black;
    }

    .search-message {
      text-align: center;
      margin-top: 20px;
      font-size: 16px;
      color: #333;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      nav ul {
        flex-direction: column;
        gap: 10px;
      }

      .search-bar input[type="text"] {
        width: 150px;
      }
    }

    /* Footer */
    footer {
      background-color: #222;
      color: #fff;
      padding: 40px 20px;
      text-align: left;
    }

    .footer-section {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }

    .footer-section div {
      flex: 1;
      min-width: 250px;
    }

    .footer-section h2 {
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .footer-section p {
      margin-bottom: 10px;
    }

    .social-icons a {
      color: #fff;
      margin-right: 10px;
      font-size: 1.5rem;
      transition: color 0.3s;
    }

    .social-icons a:hover {
      color: red;
    }

    .copyright {
      text-align: center;
      margin-top: 20px;
      border-top: 1px solid #444;
      padding-top: 20px;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" crossorigin="anonymous"></script>

</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="includes/image/logo.png" alt="FitZone Logo">
    </div>

    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="includes/about.php">About</a></li>
        <li><a href="includes/register.php">Register</a></li>
        <li><a href="includes/membership.php">Membership</a></li>
        <li><a href="includes/contact.php">Contact</a></li>
      </ul>
    </nav>

    <!-- Search Bar -->
    <div class="search-bar">
      <form method="POST">
        <input type="text" name="query" placeholder="Search service..." required>
        <button type="submit" name="search"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </header>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Welcome to FitZone Fitness Club</h1>
    <a href="includes/membership.php"><button class="join-btn">Join Now</button></a>
  </div>

  <!-- Search Result Logic -->
  <?php 
  if (isset($_POST['search'])) {
      $query = strtolower(trim($_POST['query']));
      echo '<div class="search-message">';
      switch ($query) {
          case 'mri scan':
              header("Location: includes/mri.php");
              exit();
          case 'emergency care':
              header("Location: emergency.php");
              exit();
          default:
              echo "No specific page found for '<strong>" . htmlspecialchars($_POST['query']) . "</strong>'.<br>Try 'MRI Scan' or 'Emergency Care'.";
      }
      echo '</div>';
  }
  ?>

  <!-- Footer Section -->
  <footer>
    <div class="footer-section">
        <!-- Newsletter -->
        <div>
            <h2>Subscribe to our Newsletter</h2>
            <p>Get the latest updates and fitness tips.</p>
            <form action="#" method="POST">
                <input type="email" name="newsletter_email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <!-- Contact Info -->
        <div>
            <h2>Contact Us</h2>
            <p><strong>Email:</strong> info@fitzone.com</p>
            <p><strong>Phone:</strong> +94 77 133 4557</p>
            <p><strong>Address:</strong> Main Street, Kurunagala, Sri Lanka</p>
        </div>

        <!-- Social Media -->
        <div>
            <h2>Follow Us</h2>
            <p>Stay connected:</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <div class="copyright">
        <hr style="border-color: #444;">
        <p>&copy; <?php echo date("Y"); ?> FitZone Fitness Club. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
