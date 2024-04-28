<?php
// Database connection
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $id = $_POST["Id"];
    $course1 = $_POST["Name"];
    $course2 = $_POST["Problem"];
   
    // Add more courses if needed

    // Prepare and execute SQL statement to insert data into the table
    $sql = "INSERT INTO problem (`Id`, `Name`, `Problem`)
            VALUES ('$id', '$course1', '$course2')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: condition_updated.php");
        exit(); // Ensure no further output is sent
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Problem Form</title>
    <style>
        /* CSS for Course Information Form */
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7; /* Light gray background */
    padding: 20px;
}

h2 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

form {
    max-width: 500px;
    margin: 0 auto;
    background-color: #f0f0f0; /* Light gray background */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"] {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50; /* Green */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049; /* Darker green on hover */
}



        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h2>Problem Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="Id">Student ID:</label>
        <input type="text" id="Id" name="Id" required><br><br>
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required><br><br>
        <label for="Problem">Problem:</label>
        <input type="text" id="problem" name="Problem" required><br><br>
    
        <!-- Add more course fields if needed -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>