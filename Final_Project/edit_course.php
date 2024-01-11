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

if (isset($_GET['courseID'])) {
    $courseID = $_GET['courseID'];

    // Fetch course information
    $sql = "SELECT * FROM Course WHERE CourseID = $courseID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        echo "Course not found";
        exit;
    }
} else {
    echo "CourseID not provided";
    exit;
}

// Update Course
if (isset($_POST['save'])) {
    $newCourseName = $_POST['newCourseName'];
    $newCourseDescription = $_POST['newCourseDescription'];
    $newInstructorID = $_POST['newInstructorID'];

    $updateSql = "UPDATE Course SET 
                  CourseName = '$newCourseName', 
                  CourseDescription = '$newCourseDescription', 
                  InstructorID = '$newInstructorID' 
                  WHERE CourseID = $courseID";
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
    <title>Edit Course</title>
</head>

<body>

    <h1>Edit Course</h1>

    <form method="post" action="">
        <label for="newCourseName">New Course Name:</label>
        <input type="text" name="newCourseName" value="<?= $course['CourseName'] ?>" required>
        <label for="newCourseDescription">New Course Description:</label>
        <textarea name="newCourseDescription" required><?= $course['CourseDescription'] ?></textarea>
        <label for="newInstructorID">New Instructor:</label>
        <select name="newInstructorID">
            <?php
            $sqlGetInstructors = "SELECT * FROM Instructor";
            $result = $conn->query($sqlGetInstructors);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['InstructorID'] == $course['InstructorID']) ? 'selected' : '';
                    echo "<option value='{$row['InstructorID']}' $selected>{$row['FirstName']} {$row['LastName']}</option>";
                }
            } else {
                echo "<option value=''>No instructors found</option>";
            }
            ?>
        </select>
        <input type="submit" name="save" value="Save">
        <a href="index.php">Cancel</a>
    </form>

</body>

</html>

<?php
$conn->close();
?>
