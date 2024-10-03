<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nipt_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $address = trim($_POST['address']);
    $bloodgroup = trim($_POST['bloodgroup']);
    $pwd = trim($_POST['pwd']);

    // Assuming user is logged in and user ID is stored in session
    session_start();
    $user_id = $_SESSION['user_id'];

    // Update user data
    $sql = "UPDATE users SET address = ?, bloodgroup = ?, pwd = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $address, $bloodgroup, $pwd, $user_id);

    if ($stmt->execute()) {
        // Redirect to mypage.php after successful update
        header("Location: mypage.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
