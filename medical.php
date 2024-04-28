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
    $name = $_POST["Name"];
    $fathers_name = $_POST["FathersName"];
    $mothers_name = $_POST["MothersName"];
    $blood_group = $_POST["BloodGroup"];
    $contact_number = $_POST["ContactNumber"];
    $previous_health_issues = $_POST["PreviousHealthIssues"];
    $current_health_issue = $_POST["CurrentHealthIssue"];

    // Prepare and execute SQL statement to insert data into the table
    $sql = "INSERT INTO medical (Id, Name, FathersName, MothersName, BloodGroup, ContactNumber, PreviousHealthIssues, CurrentHealthIssue)
            VALUES ('$id', '$name', '$fathers_name', '$mothers_name', '$blood_group', '$contact_number', '$previous_health_issues', '$current_health_issue')";
    
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
    <title>Problem Form</title>
    <style>
        /* CSS for Problem Form */
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
    </style>
</head>
<body>
    <h2>Problem Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="Id">Student ID:</label>
        <input type="text" id="Id" name="Id" required><br><br>
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required><br><br>
        <label for="FathersName">Father's Name:</label>
        <input type="text" id="FathersName" name="FathersName" required><br><br>
        <label for="MothersName">Mother's Name:</label>
        <input type="text" id="MothersName" name="MothersName" required><br><br>
        <label for="BloodGroup">Blood Group:</label>
        <input type="text" id="BloodGroup" name="BloodGroup" required><br><br>
        <label for="ContactNumber">Contact Number:</label>
        <input type="text" id="ContactNumber" name="ContactNumber" required><br><br>
        <label for="PreviousHealthIssues">Previous Health Issues:</label>
        <input type="text" id="PreviousHealthIssues" name="PreviousHealthIssues" required><br><br>
        <label for="CurrentHealthIssue">Current Health Issue:</label>
        <input type="text" id="CurrentHealthIssue" name="CurrentHealthIssue" required><br><br>
    
        <button type="submit">Submit</button>
    </form>
</body>
</html>
