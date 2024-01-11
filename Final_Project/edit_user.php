<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ancheta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Fetch user information
    $sql = "SELECT * FROM Users WHERE UserID = $userID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found";
        exit;
    }
} else {
    echo "UserID not provided";
    exit;
}

// Update User
if (isset($_POST['save'])) {
    $newUsername = $_POST['newUsername'];

    $updateSql = "UPDATE Users SET Username = '$newUsername' WHERE UserID = $userID";
    $conn->query($updateSql);

    // Redirect back to the main page after updating
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit User</title>
</head>

<body>

    <h1>Edit User</h1>

    <form method="post" action="">
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" value="<?= $user['Username'] ?>" required>
        <input type="submit" name="save" value="Save">
        <a href="index.php">Cancel</a>
    </form>

</body>

</html>

<?php
// Close the connection
$conn->close();
?>
