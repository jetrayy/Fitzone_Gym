<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$selectedTab = $_GET['tab'] ?? 'bronze';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FitZone Membership</title>
  <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('image/bg-image5.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    /* Header/Nav */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0, 0, 0, 0.8);
      padding: 10px 40px;
    }

    header .logo img {
      height: 50px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      padding: 0;
      margin: 0;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 16px;
      transition : background 0.3s;
    }

    nav ul li a:hover ,
    .nav-links li a.active {
      color: #e63946;
    }

    /* Membership Section */
    .membership-wrapper {
      display: flex;
      max-width: 1200px;
      margin: 60px auto;
      background: rgba(0, 0, 0, 0.75);
      border-radius: 20px;
      overflow: hidden;
    }

    .tab-buttons {
      display: flex;
      flex-direction: column;
      background: #111;
      width: 200px;
    }

    .tab-buttons button {
      padding: 20px;
      background: transparent;
      border: none;
      color: white;
      font-size: 16px;
      text-align: left;
      cursor: pointer;
      transition: all 0.3s ease;
      border-bottom: 1px solid #222;
    }

    .tab-buttons button.active,
    .tab-buttons button:hover {
      background: red;
      font-weight: bold;
    }

    .tab-content {
      flex: 1;
      padding: 30px;
      display: none;
      animation: fadeIn 0.5s ease;
    }

    .tab-content.active {
      display: block;
    }

    .tab-content h2 {
      margin-top: 0;
      font-size: 28px;
      color: red;
    }

    .tab-content p {
      line-height: 1.6;
    }

    .purchase-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background: red;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s;
    }

    .purchase-btn:hover {
      background: #c70000;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 768px) {
      .membership-wrapper {
        flex-direction: column;
      }

      .tab-buttons {
        flex-direction: row;
        overflow-x: auto;
        width: 100%;
      }

      .tab-buttons button {
        flex: 1;
        text-align: center;
        border-right: 1px solid #222;
      }

      .tab-buttons button:last-child {
        border-right: none;
      }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="image/logo.png" alt="FitZone Logo">
    </div>
    <nav>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a class="active" href="membership.php">Membership</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- MEMBERSHIP PLANS -->
  <div class="membership-wrapper">
    <div class="tab-buttons">
      <button onclick="showTab('bronze')" id="btn-bronze">Bronze</button>
      <button onclick="showTab('silver')" id="btn-silver">Silver</button>
      <button onclick="showTab('gold')" id="btn-gold">Gold</button>
    </div>

    <div id="bronze" class="tab-content">
      <h2>Bronze Plan - Rs.1000/month</h2>
      <p>✅ Gym Floor Access<br>❌ No Classes<br>❌ No Personal Trainer</p>
      <?php if ($isLoggedIn): ?>
        <a class="purchase-btn" href="purchase.php?plan=bronze">Purchase</a>
      <?php else: ?>
        <a class="purchase-btn" href="register.php?redirect=membership.php&plan=bronze">Login to Purchase</a>
      <?php endif; ?>
    </div>

    <div id="silver" class="tab-content">
      <h2>Silver Plan - Rs.2000/month</h2>
      <p>✅ Gym Floor Access<br>✅ Group Classes<br>❌ No Personal Trainer</p>
      <?php if ($isLoggedIn): ?>
        <a class="purchase-btn" href="purchase.php?plan=silver">Purchase</a>
      <?php else: ?>
        <a class="purchase-btn" href="register.php?redirect=membership.php&plan=silver">Login to Purchase</a>
      <?php endif; ?>
    </div>

    <div id="gold" class="tab-content">
      <h2>Gold Plan - Rs.3000/month</h2>
      <p>✅ Full Access<br>✅ Group Classes<br>✅ Personal Trainer</p>
      <?php if ($isLoggedIn): ?>
        <a class="purchase-btn" href="purchase.php?plan=gold">Purchase</a>
      <?php else: ?>
        <a class="purchase-btn" href="register.php?redirect=membership.php&plan=gold">Login to Purchase</a>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function showTab(tab) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
      document.querySelectorAll('.tab-buttons button').forEach(btn => btn.classList.remove('active'));

      document.getElementById(tab).classList.add('active');
      document.getElementById('btn-' + tab).classList.add('active');
    }

    // Initialize with selected tab
    const activeTab = '<?= $selectedTab ?>';
    showTab(activeTab);
  </script>

</body>
</html>
