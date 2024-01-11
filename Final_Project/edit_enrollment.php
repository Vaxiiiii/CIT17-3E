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

if (isset($_GET['enrollmentID'])) {
    $enrollmentID = $_GET['enrollmentID'];

    // Fetch enrollment information
    $sql = "SELECT * FROM Enrollment WHERE EnrollmentID = $enrollmentID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $enrollment = $result->fetch_assoc();
    } else {
        echo "Enrollment not found";
        exit;
    }
} else {
    echo "EnrollmentID not provided";
    exit;
}

// Update Enrollment
if (isset($_POST['save'])) {
    $newStudentID = $_POST['newStudentID'];
    $newCourseID = $_POST['newCourseID'];
    $newEnrollmentDate = $_POST['newEnrollmentDate'];

    $updateSql = "UPDATE Enrollment SET 
                  StudentID = '$newStudentID', 
                  CourseID = '$newCourseID', 
                  EnrollmentDate = '$newEnrollmentDate' 
                  WHERE EnrollmentID = $enrollmentID";
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
    <title>Edit Enrollment</title>
</head>

<body>

    <h1>Edit Enrollment</h1>

    <form method="post" action="">
        <label for="newStudentID">New Student:</label>
        <select name="newStudentID">
            <?php
            $sqlGetStudents = "SELECT * FROM Student";
            $result = $conn->query($sqlGetStudents);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['StudentID'] == $enrollment['StudentID']) ? 'selected' : '';
                    echo "<option value='{$row['StudentID']}' $selected>{$row['FirstName']} {$row['LastName']}</option>";
                }
            } else {
                echo "<option value=''>No students found</option>";
            }
            ?>
        </select>
        <label for="newCourseID">New Course:</label>
        <select name="newCourseID">
            <?php
            $sqlGetCourses = "SELECT * FROM Course";
            $result = $conn->query($sqlGetCourses);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['CourseID'] == $enrollment['CourseID']) ? 'selected' : '';
                    echo "<option value='{$row['CourseID']}' $selected>{$row['CourseName']}</option>";
                }
            } else {
                echo "<option value=''>No courses found</option>";
            }
            ?>
        </select>
        <label for="newEnrollmentDate">New Enrollment Date:</label>
        <input type="date" name="newEnrollmentDate" value="<?= $enrollment['EnrollmentDate'] ?>" required>
        <input type="submit" name="save" value="Save">
        <a href="index.php">Cancel</a>
    </form>

</body>

</html>

<?php
// Close the connection
$conn->close();
?>
