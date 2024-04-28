<?php
// Connect to your database
$servername = "localhost"; 
$username = "username"; 
$password = "password";
$dbname = "login"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM facultys";
$result = $conn->query($sql);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); 
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green */
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray alternating rows */
        }

        tr:hover {
            background-color: #ddd; /* Darker gray on hover */
        }

        /* Button styles */
        .button {
            display: inline-block;
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Responsive table styles */
        @media screen and (max-width: 600px) {
            table {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <h1>Faculty Information</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Initial</th><th>Mail</th><th>Courses</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Initial"] . "</td>";
            echo "<td>" . $row["Mail"] . "</td>";
            echo "<td>" . $row["Courses"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No courses available.";
    }
    ?>
</body>
</html>
