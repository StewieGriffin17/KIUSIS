<?php
include('db.php'); 
session_start(); 


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit(); 
}

$logged_in_student_name = $_SESSION["username"]; 


$student_query = "SELECT * FROM student WHERE name = '$logged_in_student_name'"; 
$student_result = $conn->query($student_query);

if ($student_result->num_rows > 0) {
    $student = $student_result->fetch_assoc(); 
} else {
    echo "Student not found.";
    exit; 
}


function add_course($conn, $logged_in_student_name, $course_code) {

    $query = "SELECT seat_count FROM sections WHERE course_code = '$course_code' AND section_number = 1";
    $result = $conn->query($query);
    $section = $result->fetch_assoc();
    
    if ($section['seat_count'] <= 0) {
        return; 
    }

   
    $query = "SELECT current_courses FROM student WHERE name = '$logged_in_student_name'";
    $result = $conn->query($query);
    $student = $result->fetch_assoc();
    
    $current_courses = json_decode($student['current_courses'], true); 
    if (!is_array($current_courses)) {
        $current_courses = [];
    }


    if (in_array($course_code, $current_courses)) {
        return;
    }

  
    $current_courses[] = $course_code;
    
    $new_courses = json_encode($current_courses);
    $update_query = "UPDATE student SET current_courses = '$new_courses' WHERE name = '$logged_in_student_name'";
    $conn->query($update_query);

 
    $decrease_seat_query = "UPDATE sections SET seat_count = GREATEST(seat_count - 1, 0) WHERE course_code = '$course_code' AND section_number = 1";
    $conn->query($decrease_seat_query);
}


function remove_course($conn, $logged_in_student_name, $course_code) {
   
    $query = "SELECT current_courses FROM student WHERE name = '$logged_in_student_name'";
    $result = $conn->query($query);
    $student = $result->fetch_assoc();
    
    $current_courses = json_decode($student['current_courses'], true); 
    if (!is_array($current_courses)) {
        $current_courses = [];
    }

   
    $current_courses = array_filter($current_courses, function($cc) use ($course_code) {
        return $cc != $course_code; 
    });

    $new_courses = json_encode($current_courses);
    $update_query = "UPDATE student SET current_courses = '$new_courses' WHERE name = '$logged_in_student_name'";
    $conn->query($update_query);

   
    $increase_seat_query = "UPDATE sections SET seat_count = LEAST(seat_count + 1, 30) WHERE course_code = '$course_code' AND section_number = 1";
    $conn->query($increase_seat_query);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_course']) && isset($_POST['course_id'])) {
        $course_code = $_POST['course_id'];
        add_course($conn, $logged_in_student_name, $course_code); 
    } elseif (isset($_POST['remove_course']) && isset($_POST['course_id'])) {
        $course_code = $_POST['course_id'];
        remove_course($conn, $logged_in_student_name, $course_code); 
    }
}

$course_query = "SELECT * FROM courses";
$course_result = $conn->query($course_query);


$search_query = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_course'])) {
    $search_query = $_POST['search_query'];
    $course_query = "SELECT * FROM courses WHERE course_name LIKE '%$search_query%' OR course_code LIKE '%$search_query%'";
    $course_result = $conn->query($course_query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Advising</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<head>
    <meta charset="UTF-8">
    <title>Student Advising</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <head>
    <meta charset="UTF-8">
    <title>Student Advising</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>

body {
    font-family: 'Roboto', sans-serif; 
    background-color: #f9f9f9; 
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px; 
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff; 
    border-radius: 10px; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
}


h1, h2, h3 {
    color: #333; 
    text-align: center; 
    margin-top: 10px;
}


ul {
    list-style-type: none; 
    padding: 0;
}

li {
    background-color: #f0f0f0; 
    padding: 10px 15px; 
    border-radius: 5px; 
    border: 1px solid #ddd; 
    margin: 10px 0; 
    transition: all 0.3s ease; 
}

li:hover {
    background-color: #e0e0e0; 
}


form {
    text-align: center; 
    margin-top: 20px; 
}

input[type="text"] {
    width: 80%; 
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}

select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}

button {
    padding: 10px 20px;
    background-color: #4CAF50; /* Vibrant green */
    color: white; /* White text */
    border: none;
    border-radius: 5px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Button shadow */
    cursor: pointer; /* Pointer cursor */
    transition: all 0.3s ease; /* Smooth transition */
}

button:hover {
    background-color: #45a049; /* Darker green on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    input[type="text"], select {
        width: 100%; /* Full width on smaller screens */
    }

    .container {
        padding: 15px; /* Smaller padding for narrow screens */
    }
}
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h1>

    <!-- Display Current Courses -->
    <h2>Advised Courses</h2>
    <ul>
    <?php
    $current_courses = json_decode($student['current_courses'], true); 
    if (is_array($current_courses) && count($current_courses) > 0) {
        foreach ($current_courses as $course_code) {
            mysqli_data_seek($course_result, 0); // Reset pointer
            while ($course = $course_result->fetch_assoc()) {
                if ($course['course_code'] == $course_code) {
                    echo "<li>{$course['course_name']} ({$course['course_code']})"; // Display course

                    // Add a "Remove" button beside the course
                    echo '<form method="post" style="display:inline;">';
                    echo '<input type="hidden" name="course_id" value="'.$course_code.'">';
                    echo '<button type="submit" name="remove_course" class="remove-button">Remove</button>';
                    echo '</form>';
                    echo "</li>"; 
                }
            }
        }
    } else {
        echo "<li>No current courses.</li>"; 
    }
    ?>
    </ul>

    <!-- Find Courses with Integrated Search -->
    <h2>Find Courses</h2>
    <form method="post" class="course-form">
        <select name="course_id"> <!-- Dropdown for courses with seat count -->
        <?php
        mysqli_data_seek($course_result, 0); 
        while ($course = $course_result->fetch_assoc()) {
            // Fetch the seat count for "Section 1"
            $seat_query = "SELECT seat_count FROM sections WHERE course_code = '{$course['course_code']}' AND section_number = 1";
            $seat_result = $conn->query($seat_query);
            $section = $seat_result->fetch_assoc();

            $seat_count = $section['seat_count'];

            echo "<option value=\"{$course['course_code']}\">{$course['course_name']} ({$course['course_code']}) - {$seat_count} seats available</option>";
        }
        ?>
        </select>
        
        <!-- Search Bar for Finding Courses -->
        <input type="text" name="search_query" placeholder="Search courses" class="search-input"> 
        
        <!-- Button to Trigger the Search -->
        <button type="submit" name="search_course" class="search-button">Search Courses</button> 
        
        <!-- Button to Add Courses -->
        <button type="submit" name="add_course" class="add-button">Add Courses</button>

        <button  name="Back" ><a href="student_dashboard.php">Back</a></button>
    </form>

</body>
</html>


