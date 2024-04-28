<?php
// Database connection
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $id = $_POST["Id"];
    $course1 = $_POST["Course_1"];
    $course2 = $_POST["Course_2"];
    $course3 = $_POST["Course_3"];
    $course4 = $_POST["Course_4"];
    $course5 = $_POST["Course_5"];


    $sql = "INSERT INTO information (`Id`, `course 1`, `course 2`, `course 3`, `course 4`, `course 5`)
            VALUES ('$id', '$course1', '$course2', '$course3', '$course4', '$course5')";
    
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
    <title>Course Information Form</title>
    <style>
      
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
    background-color: #f0f0f0; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
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
    background-color: #45a049; 
}



       
    </style>
</head>
<body>
    <h2>Course Information Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="Id">Student ID:</label>
        <input type="text" id="Id" name="Id" required><br><br>
        <label for="Course_1">Course 1:</label>
        <input type="text" id="Course_1" name="Course_1" required><br><br>
        <label for="Course_2">Course 2:</label>
        <input type="text" id="Course_2" name="Course_2" required><br><br>
        <label for="Course_3">Course 3:</label>
        <input type="text" id="Course_3" name="Course_3" required><br><br>
        <label for="Course_4">Course 4:</label>
        <input type="text" id="Course_4" name="Course_4" required><br><br>
        <label for="Course_5">Course 5:</label>
        <input type="text" id="Course_5" name="Course_5" required><br><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>




