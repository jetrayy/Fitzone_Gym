<?php 
session_start();
include('../dbconnect.php');

// Delete trainer
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM trainers WHERE trainer_id = $id";
    mysqli_query($conn, $query);
    header("Location: managetrainers.php");
    exit();
}

// Fetch all trainers
$query = "SELECT * FROM trainers";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Trainers </title>
    <link rel="icon" type="image/x-icon" href="../image/icons/sicon.ico">
    <style>
        body {
            background-color: #111;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: black;
            display: flex;
            align-items: center;
            padding: 15px 20px;
        }
        .header img {
            height: 40px;
            margin-right: 10px;
        }
        .header h1 {
            color: #dc3545;
            font-size: 2.5em;
            margin: 0;
            text-align: center;
            flex-grow: 1;
        }
        .container {
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            margin-bottom: 40px;
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            width: 50%; /* Center the form */
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            background-color: #333;
            color: white;
            border: 1px solid #555;
            border-radius: 4px;
        }
        button {
            margin-top: 15px;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #dc3545;
        }
        table {
            width: 80%; /* Center the table */
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #222;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #444;
            text-align: center;
        }
        table th {
            background-color: #dc3545;
        }
        .profile {
            max-width: 80px;
            border-radius: 6px;
        }
        a {
            color:rgb(196, 0, 0);
            text-decoration: none;
        }
        .btn-delete {
            background-color: crimson;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-delete:hover {
            background-color: darkred;
        }
        .back-btn {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="../image/logo.png" alt="Logo">
    <h1> Manage Trainers</h1>
</div>

<div class="container">

    <div class="back-btn">
        <a href="dashboard.php">
            <button>← Go Back</button>
        </a>
    </div>

    <form method="POST" action="addtrainer.php" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Specialty:</label>
        <input type="text" name="specialty" required>

        <label>Experience (Years):</label>
        <input type="number" name="experience" required>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Trainer</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Experience</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['trainer_id'] ?></td>
                <td><img src="<?= htmlspecialchars($row['profile']) ?>" class="profile" alt="Trainer Image"></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['specialty']) ?></td>
                <td><?= htmlspecialchars($row['experience']) ?> years</td>
                <td>
                    <a href="updatetrainer.php?id=<?= $row['trainer_id'] ?>" class="btn-delete">Edit</a> |
                    <a href="managetrainers.php?delete=<?= $row['trainer_id'] ?>" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>
