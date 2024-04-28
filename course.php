<?php
// Connect to your database
$servername = "localhost"; // Change this to your server name
$username = "username"; // Change this to your database username
$password = "password"; // Change this to your database password
$dbname = "login"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch course information
$sql = "SELECT * FROM course";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Information</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light gray background */
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff; /* White background */
    border-radius: 8px; /* Rounded corners */
    overflow: hidden; /* Hide overflow content */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #4CAF50; /* Green */
    color: #fff; /* White text */
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Light gray alternating rows */
}

tr:hover {
    background-color: #f2f2f2; /* Darker gray on hover */
}

h1 {
    color: #333; /* Dark gray */
    margin-bottom: 20px;
}


    </style>
</head>
<body>
    <h1>Course Information</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Course Name</th><th>Faculty Name</th><th>Seats</th><th>Timing</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Faculty"] . "</td>";
            echo "<td>" . $row["Seats"] . "</td>";
            echo "<td>" . $row["Timing"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No courses available.";
    }
    ?>
</body>
</html>
