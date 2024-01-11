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

if (isset($_GET['instructorID'])) {
    $instructorID = $_GET['instructorID'];

    // Fetch instructor information
    $sql = "SELECT * FROM Instructor WHERE InstructorID = $instructorID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $instructor = $result->fetch_assoc();
    } else {
        echo "Instructor not found";
        exit;
    }
} else {
    echo "InstructorID not provided";
    exit;
}

// Update Instructor
if (isset($_POST['save'])) {
    $newInstructorFirstName = $_POST['newInstructorFirstName'];
    $newInstructorLastName = $_POST['newInstructorLastName'];
    $newInstructorContactNumber = $_POST['newInstructorContactNumber'];
    $newInstructorEmail = $_POST['newInstructorEmail'];

    $updateSql = "UPDATE Instructor SET 
                  FirstName = '$newInstructorFirstName', 
                  LastName = '$newInstructorLastName', 
                  ContactNumber = '$newInstructorContactNumber', 
                  Email = '$newInstructorEmail' 
                  WHERE InstructorID = $instructorID";
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
    <title>Edit Instructor</title>
</head>

<body>

    <h1>Edit Instructor</h1>

    <form method="post" action="">
        <label for="newInstructorFirstName">New First Name:</label>
        <input type="text" name="newInstructorFirstName" value="<?= $instructor['FirstName'] ?>" required>
        <label for="newInstructorLastName">New Last Name:</label>
        <input type="text" name="newInstructorLastName" value="<?= $instructor['LastName'] ?>" required>
        <label for="newInstructorContactNumber">New Contact Number:</label>
        <input type="text" name="newInstructorContactNumber" value="<?= $instructor['ContactNumber'] ?>" required>
        <label for="newInstructorEmail">New Email:</label>
        <input type="email" name="newInstructorEmail" value="<?= $instructor['Email'] ?>" required>
        <input type="submit" name="save" value="Save">
        <a href="index.php">Cancel</a>
    </form>

</body>

</html>

<?php
// Close the connection
$conn->close();
?>
