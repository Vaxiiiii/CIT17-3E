<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ancheta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
    $username = $_POST["username"];

    $sqlAddUser = "INSERT INTO Users (Username, UserType) VALUES ('$username', 'Regular')";
    $conn->query($sqlAddUser);
}

// Handle Add Student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addStudent"])) {
    // Retrieve and sanitize form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $dob = $_POST["dob"];
    $contactNumber = $_POST["contactNumber"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Insert data into the Student table
    $sqlAddStudent = "INSERT INTO Student (FirstName, LastName, DateOfBirth, ContactNumber, Email, Address) 
                      VALUES ('$firstName', '$lastName', '$dob', '$contactNumber', '$email', '$address')";
    $conn->query($sqlAddStudent);
}

// Handle Add Course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCourse"])) {
    // Retrieve and sanitize form data
    $courseName = $_POST["courseName"];
    $courseDescription = $_POST["courseDescription"];
    $instructorID = $_POST["instructorID"];

    // Insert data into the Course table
    $sqlAddCourse = "INSERT INTO Course (CourseName, CourseDescription, InstructorID) 
                     VALUES ('$courseName', '$courseDescription', '$instructorID')";
    $conn->query($sqlAddCourse);
}

// Handle Add Instructor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addInstructor"])) {
    // Retrieve and sanitize form data
    $instructorFirstName = $_POST["instructorFirstName"];
    $instructorLastName = $_POST["instructorLastName"];
    $instructorContactNumber = $_POST["instructorContactNumber"];
    $instructorEmail = $_POST["instructorEmail"];

    // Insert data into the Instructor table
    $sqlAddInstructor = "INSERT INTO Instructor (FirstName, LastName, ContactNumber, Email) 
                         VALUES ('$instructorFirstName', '$instructorLastName', '$instructorContactNumber', '$instructorEmail')";
    $conn->query($sqlAddInstructor);
}

// Handle Add Enrollment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addEnrollment"])) {
    // Retrieve and sanitize form data
    $studentID = $_POST["studentID"];
    $courseID = $_POST["courseID"];
    $enrollmentDate = $_POST["enrollmentDate"];

    // Insert data into the Enrollment table
    $sqlAddEnrollment = "INSERT INTO Enrollment (StudentID, CourseID, EnrollmentDate) 
                         VALUES ('$studentID', '$courseID', '$enrollmentDate')";
    $conn->query($sqlAddEnrollment);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Information System</title>
        <link rel="stylesheet" href="styles.css">
    </head>

<body>

<h1>STUDENT INFORMATION SYSTEM</h1>

<!-- Add User Form -->
<form method="post">
    <h2>Add User</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <button type="submit" name="addUser">Add User</button>
</form>

<!-- List of Users -->
<h2>Existing Users</h2>
<table border="1">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Action</th>
    </tr>
    <?php
    $sqlGetUsers = "SELECT * FROM Users";
    $result = $conn->query($sqlGetUsers);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['UserID']}</td>
                    <td>{$row['Username']}</td>
                    <td>
                        <a href='edit_user.php?userID={$row['UserID']}'>Edit</a>
                        <a href='index.php?deleteUserID={$row['UserID']}' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No users found.</td></tr>";
    }
    ?>
</table>

<?php
// Handle Delete User
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteUserID"])) {
    $deleteUserID = $_GET["deleteUserID"];
    $sqlDeleteUser = "DELETE FROM Users WHERE UserID = '$deleteUserID'";
    $conn->query($sqlDeleteUser);

    header("Location: index.php");
    exit;
}
?>


<!-- Add Student Form -->
<form method="post">
    <h2>Add Student</h2>
    <label for="firstName">First Name:</label>
    <input type="text" name="firstName" required>
    <label for="lastName">Last Name:</label>
    <input type="text" name="lastName" required>
    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" required>
    <label for="contactNumber">Contact Number:</label>
    <input type="text" name="contactNumber" required>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <label for="address">Address:</label>
    <input type="text" name="address" required>
    <button type="submit" name="addStudent">Add Student</button>
</form>

<!-- List of Students -->
<h2>Existing Students</h2>
<table border="1">
    <tr>
        <th>Student ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Action</th>
    </tr>
    <?php
    $sqlGetStudents = "SELECT * FROM Student";
    $resultStudents = $conn->query($sqlGetStudents);

    if ($resultStudents->num_rows > 0) {
        while ($row = $resultStudents->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['StudentID']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>
                        <a href='edit_student.php?studentID={$row['StudentID']}'>Edit</a>
                        <a href='index.php?deleteStudentID={$row['StudentID']}' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No students found.</td></tr>";
    }
    ?>
</table>

<?php
// Handle Delete Student
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteStudentID"])) {
    $deleteStudentID = $_GET["deleteStudentID"];

    // Check if there are related records in the Enrollment table
    $sqlCheckEnrollments = "SELECT * FROM Enrollment WHERE StudentID = '$deleteStudentID'";
    $resultEnrollments = $conn->query($sqlCheckEnrollments);

    if ($resultEnrollments->num_rows > 0) {
        echo "Cannot delete the student because there are related enrollments. Please remove the enrollments first.";
    } else {
        // No related records, proceed with deletion
        $sqlDeleteStudent = "DELETE FROM Student WHERE StudentID = '$deleteStudentID'";
        $conn->query($sqlDeleteStudent);

        header("Location: index.php");
        exit;

    }
}
?>

<!-- Add Instructor Form -->
<form method="post">
    <h2>Add Instructor</h2>
    <label for="instructorFirstName">First Name:</label>
    <input type="text" name="instructorFirstName" required>
    <label for="instructorLastName">Last Name:</label>
    <input type="text" name="instructorLastName" required>
    <label for="instructorContactNumber">Contact Number:</label>
    <input type="text" name="instructorContactNumber" required>
    <label for="instructorEmail">Email:</label>
    <input type="email" name="instructorEmail" required>
    <button type="submit" name="addInstructor">Add Instructor</button>
</form>

<!-- List of Instructors -->
<h2>Existing Instructors</h2>
<table border="1">
    <tr>
        <th>Instructor ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Action</th>
    </tr>
    <?php
    $sqlGetInstructors = "SELECT * FROM Instructor";
    $resultInstructors = $conn->query($sqlGetInstructors);

    if ($resultInstructors->num_rows > 0) {
        while ($row = $resultInstructors->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['InstructorID']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>
                        <a href='edit_instructor.php?instructorID={$row['InstructorID']}'>Edit</a>
                        <a href='index.php?deleteInstructorID={$row['InstructorID']}' onclick='return confirm(\"Are you sure you want to delete this instructor?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No instructors found.</td></tr>";
    }
    ?>
</table>


<?php
// Handle Delete Instructor
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteInstructorID"])) {
    $deleteInstructorID = $_GET["deleteInstructorID"];

    // Check if there are related records in the Course table
    $sqlCheckCourses = "SELECT * FROM Course WHERE InstructorID = '$deleteInstructorID'";
    $resultCourses = $conn->query($sqlCheckCourses);

    if ($resultCourses->num_rows > 0) {
        echo "Cannot delete the instructor because there are related courses. Please remove the courses first.";
    } else {
        // No related records in Courses, proceed to delete the instructor
        $sqlDeleteInstructor = "DELETE FROM Instructor WHERE InstructorID = '$deleteInstructorID'";
        $conn->query($sqlDeleteInstructor);

        header("Location: index.php");
        exit;
    }
}
?>

<!-- Add Course Form -->
<form method="post">
    <h2>Add Course</h2>
    <label for="courseName">Course Name:</label>
    <input type="text" name="courseName" required>
    <label for="courseDescription">Course Description:</label>
    <textarea name="courseDescription" required></textarea>
    <label for="instructorID">Instructor:</label>
    <select name="instructorID">
        <?php
        $sqlGetInstructors = "SELECT * FROM Instructor";
        $result = $conn->query($sqlGetInstructors);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['InstructorID']}'>{$row['FirstName']} {$row['LastName']}</option>";
            }
        } else {
            echo "<option value=''>No instructors found</option>";
        }
        ?>
    </select>
    <button type="submit" name="addCourse">Add Course</button>
</form>

<!-- List of Courses -->
<h2>Existing Courses</h2>
<table border="1">
    <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Course Description</th>
        <th>Action</th>
    </tr>
    <?php
    $sqlGetCourses = "SELECT * FROM Course";
    $resultCourses = $conn->query($sqlGetCourses);

    if ($resultCourses->num_rows > 0) {
        while ($row = $resultCourses->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['CourseID']}</td>
                    <td>{$row['CourseName']}</td>
                    <td>{$row['CourseDescription']}</td>
                    <td>
                        <a href='edit_course.php?courseID={$row['CourseID']}'>Edit</a>
                        <a href='index.php?deleteCourseID={$row['CourseID']}' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No courses found.</td></tr>";
    }
    ?>
</table>

<?php
// Handle Delete Course
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteCourseID"])) {
    $deleteCourseID = $_GET["deleteCourseID"];

    // Check if there are related records in the Enrollment table
    $sqlCheckEnrollments = "SELECT * FROM Enrollment WHERE CourseID = '$deleteCourseID'";
    $resultEnrollments = $conn->query($sqlCheckEnrollments);

    if ($resultEnrollments->num_rows > 0) {
        echo "Cannot delete the course because there are related enrollments. Please remove the enrollments first.";
    } else {
        // No related records, proceed with deletion
        try {
            $sqlDeleteCourse = "DELETE FROM Course WHERE CourseID = '$deleteCourseID'";
            $conn->query($sqlDeleteCourse);

            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            echo "Error deleting course: " . $e->getMessage();
        }
    }
}
?>

<!-- Add Enrollment Form -->
<form method="post">
    <h2>Add Enrollment</h2>
    <label for="studentID">Student:</label>
    <select name="studentID">
        <?php
        $sqlGetStudents = "SELECT * FROM Student";
        $result = $conn->query($sqlGetStudents);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['StudentID']}'>{$row['FirstName']} {$row['LastName']}</option>";
            }
        } else {
            echo "<option value=''>No students found</option>";
        }
        ?>
    </select>
    <label for="courseID">Course:</label>
    <select name="courseID">
        <?php
        $sqlGetCourses = "SELECT * FROM Course";
        $result = $conn->query($sqlGetCourses);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['CourseID']}'>{$row['CourseName']}</option>";
            }
        } else {
            echo "<option value=''>No courses found</option>";
        }
        ?>
    </select>
    <label for="enrollmentDate">Enrollment Date:</label>
    <input type="date" name="enrollmentDate" required>
    <button type="submit" name="addEnrollment">Add Enrollment</button>
</form>

<!-- List of Enrollments -->
<h2>Existing Enrollments</h2>
<table border="1">
    <tr>
        <th>Enrollment ID</th>
        <th>Student Name</th>
        <th>Course Name</th>
        <th>Enrollment Date</th>
        <th>Action</th>
    </tr>
    <?php
    $sqlGetEnrollments = "SELECT Enrollment.EnrollmentID, Student.FirstName AS StudentFirstName, Student.LastName AS StudentLastName, Course.CourseName, Enrollment.EnrollmentDate
                         FROM Enrollment
                         JOIN Student ON Enrollment.StudentID = Student.StudentID
                         JOIN Course ON Enrollment.CourseID = Course.CourseID";
    $resultEnrollments = $conn->query($sqlGetEnrollments);

    if ($resultEnrollments->num_rows > 0) {
        while ($row = $resultEnrollments->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['EnrollmentID']}</td>
                    <td>{$row['StudentFirstName']} {$row['StudentLastName']}</td>
                    <td>{$row['CourseName']}</td>
                    <td>{$row['EnrollmentDate']}</td>
                    <td>
                        <a href='edit_enrollment.php?enrollmentID={$row['EnrollmentID']}'>Edit</a>
                        <a href='index.php?deleteEnrollmentID={$row['EnrollmentID']}' onclick='return confirm(\"Are you sure you want to delete this enrollment?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No enrollments found.</td></tr>";
    }
    ?>
</table>

<?php
// Handle Delete Enrollment
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteEnrollmentID"])) {
    $deleteEnrollmentID = $_GET["deleteEnrollmentID"];
    $sqlDeleteEnrollment = "DELETE FROM Enrollment WHERE EnrollmentID = '$deleteEnrollmentID'";
    $conn->query($sqlDeleteEnrollment);

     header("Location: index.php");
    exit;

}
?>
</body>
</html>

