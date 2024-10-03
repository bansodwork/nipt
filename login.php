<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nipt_data"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);

    // Prepare SQL statement
    $sql = "SELECT id, pwd FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error executing query: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pwd, $row['pwd'])) {
            // Password is correct, set session variable
            $_SESSION['user_id'] = $row['id'];
            // Redirect to mypage.php
            header("Location: mypage.php");
            exit();
        } else {
            // Password is incorrect
            header("Location: wrongpass.html");
            exit();
        }
    } else {
        // No matching records found
        header("Location: wrongpass.html");
        exit();
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
