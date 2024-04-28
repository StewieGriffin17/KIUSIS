<?php
// Database connection
$servername = "localhost"; 
$username = "username"; 
$password = "password"; 
$dbname = "login"; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $reason = isset($_POST["reason"]) ? $_POST["reason"] : "";

    $sql = "INSERT INTO scholarship (id, name, reason) VALUES ('$id', '$name', '$reason')";

    if ($conn->query($sql) === TRUE) {
        header("Location: condition_updated.php");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

   
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            padding: 20px;
        }

        form {
            background-color: #fff; /* White background */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
            padding: 20px;
            max-width: 600px;
            margin: 0 auto; 
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box; 
        }

        textarea {
            resize: vertical; 
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <h1>Scholarship Application Form</h1>
    <form action="Scholarship.php" method="post">
        <label for="id">Id:</label>
        <input type="text" id="id" name="id" required><br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="reason">Reason for Applying:</label>
        <textarea id="reason" name="reason" rows="4" required></textarea>

        <input type="submit" value="Submit Application">
    </form>
</body>
</html>


