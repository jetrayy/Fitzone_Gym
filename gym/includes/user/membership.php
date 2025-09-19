<?php 
session_start();
include('../dbconnect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Handle membership purchase
if (isset($_POST['purchase'])) {
    $plan = $_POST['plan'];
    $user_id = $_SESSION['user_id'];

    // Update the user's membership in the database
    $stmt = $conn->prepare("UPDATE users SET membership_plan = ? WHERE user_id = ?");
    $stmt->bind_param("si", $plan, $user_id);
    $stmt->execute();

    // Redirect to the user dashboard after purchase
    echo "<script>alert('Purchase Successful! Your membership has been updated.'); window.location.href = 'user_dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FitZone Membership</title>
  <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #111;
      color: white;
      padding-top: 100px; /* Avoid header overlap */
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: #000;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
    }

    .logo img {
      height: 50px;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .nav-links li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 16px;
      transition: background 0.3s;
    }

    .nav-links li a:hover {
      color: red;
    }

    .go-back-btn {
      background-color: red;
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .go-back-btn:hover {
      background-color: #c70000;
    }

    .membership-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      padding: 50px 100px;
      margin-top: 50px;
    }

    .plan {
      background-color: #222;
      width: 30%;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s ease-in-out;
    }

    .plan:hover {
      transform: translateY(-10px); /* Hover animation */
    }

    .plan h2 {
      color: red;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .plan p {
      margin-bottom: 20px;
    }

    .purchase-btn {
      padding: 12px 24px;
      background-color: red;
      color: white;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .purchase-btn:hover {
      background-color: #c70000;
    }

    footer {
      background-color: #222;
      color: white;
      padding: 30px;
      text-align: center;
      position: fixed;
      left: 0;
      right: 0;
      bottom: 0;
    }

  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="../image/logo.png" alt="FitZone Logo">
    </div>
    <a href="user_dashboard.php" class="go-back-btn">← Go Back</a>
  </header>

  <!-- MEMBERSHIP PLANS -->
  <div class="membership-wrapper">
    <!-- Bronze Plan -->
    <div class="plan">
      <h2>Bronze - Rs.1000/month</h2>
      <p>✅ Gym Access<br>❌ Classes<br>❌ Personal Trainer</p>
      <form method="POST">
        <input type="hidden" name="plan" value="bronze">
        <button type="submit" name="purchase" class="purchase-btn">Purchase</button>
      </form>
    </div>

    <!-- Silver Plan -->
    <div class="plan">
      <h2>Silver - Rs.2000/month</h2>
      <p>✅ Gym Access<br>✅ Group Classes<br>❌ Personal Trainer</p>
      <form method="POST">
        <input type="hidden" name="plan" value="silver">
        <button type="submit" name="purchase" class="purchase-btn">Purchase</button>
      </form>
    </div>

    <!-- Gold Plan -->
    <div class="plan">
      <h2>Gold - Rs.3000/month</h2>
      <p>✅ Gym Access<br>✅ Group Classes<br>✅ Personal Trainer</p>
      <form method="POST">
        <input type="hidden" name="plan" value="gold">
        <button type="submit" name="purchase" class="purchase-btn">Purchase</button>
      </form>
    </div>
  </div>

  <!-- Footer Section -->
  <footer>
    <p>&copy; 2025 FitZone Fitness Club. All Rights Reserved.</p>
  </footer>

</body>
</html>
