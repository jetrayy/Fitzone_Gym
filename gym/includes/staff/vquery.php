<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../dbconnect.php');

// Fetch all user queries that are unread
$queries = mysqli_query($conn, "SELECT * FROM queries WHERE status = 'unread' ORDER BY created_at DESC");

// Fetch all responded queries
$responded_queries = mysqli_query($conn, "SELECT * FROM queries WHERE status = 'replied' ORDER BY created_at DESC");

// Handle query reply
if (isset($_POST['reply'])) {
    $query_id = $_POST['query_id'];
    $reply = mysqli_real_escape_string($conn, $_POST['reply_text']);
    $staff_id = $_SESSION['user_id'];  // Getting the logged-in staff ID
    
    // Move query to responded table and change status to 'replied'
    mysqli_query($conn, "UPDATE queries SET reply = '$reply', staff_id = '$staff_id', status = 'replied' WHERE query_id = '$query_id'");
    
    // Redirect to avoid re-submission
    header("Location: vquery.php");
    exit;
}

// Handle query deletion (for replied queries)
if (isset($_GET['delete'])) {
    $query_id = $_GET['delete'];
    // Delete the query from the responded table
    mysqli_query($conn, "DELETE FROM queries WHERE query_id = $query_id");
    header("Location: vquery.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Queries - Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #000;
            color: #fff;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #000;
        }
        header h1 {
            color: #e63946; /* Red color for Staff Dashboard */
            font-size: 2.5em;
            margin: 0;
        }
        .back-button, .logout-button, .nav-links a {
            padding: 10px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 2px;
            cursor: pointer;
        }
        .back-button, .logout-button {
            background-color: #e63946; /* Red for buttons */
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #bbb;
            text-align: center;
        }
        th {
            background-color: #e63946; /* Red color */
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #222;
        }
        form {
            display: inline-block;
        }
        input[type="text"], textarea {
            width: 300px;
            margin: 5px 0;
            padding: 8px;
            background-color: #333;
            color: #fff;
            border: 1px solid #bbb;
        }
        button {
            padding: 10px;
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo" style="width: 100px; height: auto;">
    </div>
    <h1>View Queries</h1>
    <div>
        <!-- Update the back button to redirect to staff_page.php -->
        <a href="staff_page.php" class="button back-button">← Go Back</a>
        <a href="../logout.php" class="button logout-button">Logout</a>
    </div>
</header>


<h2>User Queries</h2>
<!-- Unread Queries -->
<table>
    <tr>
        <th>Query ID</th>
        <th>User ID</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Action</th>
    </tr>
    <?php while ($q = mysqli_fetch_assoc($queries)): ?>
    <tr>
        <td><?php echo $q['query_id']; ?></td>
        <td><?php echo $q['user_id']; ?></td>
        <td><?php echo $q['subject']; ?></td>
        <td><?php echo $q['message']; ?></td>
        <td>
            <a href="vquery.php?query_id=<?php echo $q['query_id']; ?>" class="button">Reply</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<hr>

<h2>Responded Queries</h2>
<!-- Responded Queries -->
<table>
    <tr>
        <th>Query ID</th>
        <th>Staff ID</th>
        <th>Reply</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($q = mysqli_fetch_assoc($responded_queries)): ?>
    <tr>
        <td><?php echo $q['query_id']; ?></td>
        <td><?php echo $q['staff_id']; ?></td>
        <td><?php echo $q['reply']; ?></td>
        <td><?php echo ucfirst($q['status']); ?></td>
        <td>
            <a href="?delete=<?php echo $q['query_id']; ?>" class="button cancel" onclick="return confirm('Are you sure you want to delete this responded query?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<hr>

<?php
if (isset($_GET['query_id'])) {
    $query_id = $_GET['query_id'];
    // Fetch the specific query details
    $query_detail = mysqli_query($conn, "SELECT * FROM queries WHERE query_id = $query_id");
    $query = mysqli_fetch_assoc($query_detail);
?>

<h2>Reply to Query</h2>
<form method="POST">
    <input type="hidden" name="query_id" value="<?php echo $query['query_id']; ?>">
    
    <h3>Query Message:</h3>
    <p><?php echo $query['message']; ?></p>
    
    <h3>Your Reply:</h3>
    <textarea name="reply_text" placeholder="Write your reply..." required rows="4" cols="50"></textarea><br>
    
    <button type="submit" name="reply">Submit Reply</button>
</form>

<?php } ?>

</body>
</html>
