<?php
session_start();


if (!isset($_SESSION["username"])) {
   
    header("Location: login.php");
    exit();
}


$logged_in_student_name = $_SESSION["username"];

// Connect to your database
$servername = "localhost"; 
$username = "username"; 
$password = "password"; 
$dbname = "login"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prevent SQL Injection
$logged_in_student_name = $conn->real_escape_string($logged_in_student_name);


$sql = "SELECT * FROM students WHERE Name = '$logged_in_student_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    $student = $result->fetch_assoc();
} else {

    echo "Student not found!";
    exit; 
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7; /* Light gray background */
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .student-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px;
        }

        .student-info p {
            margin: 0;
            margin-bottom: 10px;
        }

        .options {
            display: flex;
            justify-content: space-between;
        }

        .options a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green */
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .options a:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $student['Name']; ?>!</h1>

    <div class="student-info">
        <p><strong>Name:</strong> <?php echo $student['Name']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['Mail']; ?></p>
        <p><strong>CGPA:</strong> <?php echo $student['CGPA']; ?></p>
        <p><strong>Completed Credits:</strong> <?php echo $student['Completed Credit']; ?></p>
        <p><strong>Attempted Credits:</strong> <?php echo $student['Attempted Credit']; ?></p>
        <p><strong>Address:</strong> <?php echo $student['Address']; ?></p>
        <p><strong>Batch:</strong> <?php echo $student['Batch']; ?></p>
       
    </div>

    <div class="options">
        <a href="index.php">Advising</a>
        <a href="apply_courses.php">Apply for Courses</a>
        <a href="bank_details.php">Bank Details</a>
        <a href="report_problem.php">Report a Problem</a>
        <a href="Scholarship.php">Apply for Scholarship</a>
        <a href="medical.php">Medical</a>
        <a href="login.php">LogOut</a>
        
    </div>
    
</body>
</html>

