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

if (isset($_GET['studentID'])) {
    $studentID = $_GET['studentID'];

    // Fetch student information
    $sql = "SELECT * FROM Student WHERE StudentID = $studentID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found";
        exit;
    }
} else {
    echo "StudentID not provided";
    exit;
}

// Update Student
if (isset($_POST['save'])) {
    $newFirstName = $_POST['newFirstName'];
    $newLastName = $_POST['newLastName'];
    $newDob = $_POST['newDob'];
    $newContactNumber = $_POST['newContactNumber'];
    $newEmail = $_POST['newEmail'];
    $newAddress = $_POST['newAddress'];

    $updateSql = "UPDATE Student SET 
                  FirstName = '$newFirstName', 
                  LastName = '$newLastName', 
                  DateOfBirth = '$newDob', 
                  ContactNumber = '$newContactNumber', 
                  Email = '$newEmail', 
                  Address = '$newAddress' 
                  WHERE StudentID = $studentID";
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
    <title>Edit Student</title>
</head>

<body>

    <h1>Edit Student</h1>

    <form method="post" action="">
        <label for="newFirstName">New First Name:</label>
        <input type="text" name="newFirstName" value="<?= $student['FirstName'] ?>" required>
        <label for="newLastName">New Last Name:</label>
        <input type="text" name="newLastName" value="<?= $student['LastName'] ?>" required>
        <label for="newDob">New Date of Birth:</label>
        <input type="date" name="newDob" value="<?= $student['DateOfBirth'] ?>" required>
        <label for="newContactNumber">New Contact Number:</label>
        <input type="text" name="newContactNumber" value="<?= $student['ContactNumber'] ?>" required>
        <label for="newEmail">New Email:</label>
        <input type="email" name="newEmail" value="<?= $student['Email'] ?>" required>
        <label for="newAddress">New Address:</label>
        <input type="text" name="newAddress" value="<?= $student['Address'] ?>" required>
        <input type="submit" name="save" value="Save">
        <a href="index.php">Cancel</a>
    </form>

</body>

</html>

<?php
// Close the connection
$conn->close();
?>
