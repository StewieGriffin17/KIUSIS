<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username  = $_POST["username"];
    $password = $_POST["password"];

    // Prevent SQL Injection
    $username  = stripslashes($username );
    $password = stripslashes($password);

    // Deprecated MySQL extension, consusernameer using MySQLi or PDO instead
    $conn = mysqli_connect("localhost", "root", "", "login");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prevent SQL Injection
    $username  = mysqli_real_escape_string($conn, $username );
    $password = mysqli_real_escape_string($conn, $password);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username ' AND password='$password'");

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Login successful, store username in session for future use
        $_SESSION["username"] = $username ;
        // Redirect user to student dashboard
        header("Location: student_dashboard.php");
        exit();
    } else {
        echo "Failed to login!";
    }

    mysqli_close($conn);
}
?>

<!-- Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wusernameth=device-wusernameth, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>University Name</h1>
    </header>

    <main>
        <section username="login">
            <h2>Login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">username:</label>
                <input type="text" username="username" name="username" required><br><br>
                <label for="password">Password:</label>
                <input type="password" username="password" name="password" required><br><br>
                <button type="submit">Login</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 University Name. All rights reserved.</p>
    </footer>
</body>
</html>

