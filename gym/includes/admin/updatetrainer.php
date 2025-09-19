<?php 
include '../dbconnect.php';

// Fetch the trainer ID
if (isset($_GET['id'])) {
    $trainer_id = $_GET['id'];
    $query = "SELECT * FROM trainers WHERE trainer_id = $trainer_id";
    $result = mysqli_query($conn, $query);
    $trainer = mysqli_fetch_assoc($result);
    if (!$trainer) {
        echo "Trainer not found.";
        exit();
    }
} else {
    echo "No trainer ID provided.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $experience = $_POST['experience'];
    $profile = $trainer['profile'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_image_name = "trainer_" . $trainer_id . "." . $image_ext;
        $image_path = "uploads/" . $new_image_name;
        move_uploaded_file($image_tmp, $image_path);
        $profile = $image_path;
    }

    $update_query = "UPDATE trainers SET 
                    name = '$name', 
                    specialty = '$specialty', 
                    experience = '$experience', 
                    profile = '$profile' 
                    WHERE trainer_id = $trainer_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: managetrainers.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Trainer</title>
    <link rel="icon" type="image/x-icon" href="../image/icons/sicon.ico">
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color:rgb(4, 4, 4);
            margin: 0;
        }
        .header {
        background-color: #1f1f1f;
        color: white;
        padding: 15px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header img {
        height: 40px;
    }

    .header h1 {
        margin: 0;
        flex-grow: 1;
        text-align: center;
        font-size: 22px;
    }

    .container {
        max-width: 600px;
        margin: 40px auto;
        background-color:rgb(174, 44, 44);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    label {
        display: block;
        margin-bottom: 6px;
        margin-top: 15px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        background-color: #2a2a2a;
        color:white;
        border: 12x ;
        border-radius: 5px;
        box-shadow: white;
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: crimson;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: darkred;
    }

    .back-btn {
        text-decoration: none;
        color: white;
        background-color: #444;
        padding: 8px 16px;
        border-radius: 5px;
    }

    .back-btn:hover {
        background-color: #666;
    }

    .preview-img {
        margin-top: 15px;
        border-radius: 4px;
    }
</style>
</head>
<body>

<div class="header">
    <img src="../image/logo.png" alt="Logo">
    <h1>Edit Trainer</h1>
</div>

<div class="container">
    <a href="managetrainers.php"><button class="back-btn">← Go Back</button></a>

    <form method="POST" action="updatetrainer.php?id=<?= $trainer['trainer_id'] ?>" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $trainer['name'] ?>" required>

        <label>Specialty:</label>
        <input type="text" name="specialty" value="<?= $trainer['specialty'] ?>" required>

        <label>Experience (Years):</label>
        <input type="number" name="experience" value="<?= $trainer['experience'] ?>" required>

        <label>Profile Image (Leave empty if no change):</label>
        <input type="file" name="image" accept="image/*">

        <img src="<?= htmlspecialchars($trainer['profile']) ?>" class="preview" alt="Current Image">

        <br><button type="submit">Update Trainer</button>
    </form>
</div>

</body>
</html>
