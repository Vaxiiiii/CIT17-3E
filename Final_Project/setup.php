<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ancheta";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDB) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select database
$conn->select_db($dbname);

// Create Users table
$sqlCreateUsersTable = "CREATE TABLE IF NOT EXISTS Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    UserType VARCHAR(50) NOT NULL
)";
if ($conn->query($sqlCreateUsersTable) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating Users table: " . $conn->error;
}
// Create Instructor table
$sqlCreateInstructorTable = "CREATE TABLE IF NOT EXISTS Instructor (
    InstructorID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    ContactNumber INT NOT NULL,
    Email VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateInstructorTable) === TRUE) {
    echo "Instructor table created successfully<br>";
} else {
    echo "Error creating Instructor table: " . $conn->error;
}
// Create Course table
$sqlCreateCourseTable = "CREATE TABLE IF NOT EXISTS Course (
    CourseID INT AUTO_INCREMENT PRIMARY KEY,
    CourseName VARCHAR(255) NOT NULL,
    CourseDescription TEXT NOT NULL,
    InstructorID INT,
    FOREIGN KEY (InstructorID) REFERENCES Instructor(InstructorID)
)";
if ($conn->query($sqlCreateCourseTable) === TRUE) {
    echo "Course table created successfully<br>";
} else {
    echo "Error creating Course table: " . $conn->error;
}
// Create Student table
$sqlCreateStudentTable = "CREATE TABLE IF NOT EXISTS Student (
    StudentID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    DateOfBirth DATE NOT NULL,
    ContactNumber INT NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateStudentTable) === TRUE) {
    echo "Student table created successfully<br>";
} else {
    echo "Error creating Student table: " . $conn->error;
}
// Create Enrollment table
$sqlCreateEnrollmentTable = "CREATE TABLE IF NOT EXISTS Enrollment (
    EnrollmentID INT AUTO_INCREMENT PRIMARY KEY,
    StudentID INT,
    CourseID INT,
    EnrollmentDate DATE NOT NULL,
    FOREIGN KEY (StudentID) REFERENCES Student(StudentID),
    FOREIGN KEY (CourseID) REFERENCES Course(CourseID)
)";
if ($conn->query($sqlCreateEnrollmentTable) === TRUE) {
    echo "Enrollment table created successfully<br>";
} else {
    echo "Error creating Enrollment table: " . $conn->error;
}

// Close the connection
$conn->close();
?>
