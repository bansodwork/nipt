<?php
// Start the session at the very beginning
session_start();

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in first.");
}

$user_id = $_SESSION['user_id'];

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

// Fetch user data
$sql = "SELECT address, bloodgroup FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>マイページ</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        img {
            width: 400px;
            height: auto;
            margin-bottom: 20px;
        }

        h1 {
            color: #007bff;
            text-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 400px;
        }

        .futuristic-label {
            font-size: 14px;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .futuristic-input {
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background: transparent;
            color: #007bff;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .futuristic-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 10px #0056b3, 0 0 20px #0056b3, 0 0 30px #0056b3;
        }

        .submit-container {
            text-align: center;
            margin-top: 20px;
        }

        .submit-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1><br><br><br><br><br><br></h1>
    <img src="https://mykarute.com/img/bg-img/login.png" alt="jvpd image">
    <h1>マイページ</h1>
    <form action="update_user.php" method="post">
        <div class="grid-container">
            <label for="address" class="futuristic-label">住所:</label>
            <input type="text" id="address" name="address" class="futuristic-input" value="<?php echo htmlspecialchars($user['address']); ?>">

            <label for="bloodgroup" class="futuristic-label">血液型:</label>
            <input type="text" id="bloodgroup" name="bloodgroup" class="futuristic-input" value="<?php echo htmlspecialchars($user['bloodgroup']); ?>">

            <label for="pwd" class="futuristic-label">パスワード:</label>
            <input type="password" id="pwd" name="pwd" class="futuristic-input">
        </div>
        <div class="submit-container">
            <input type="submit" value="提出する">
        </div>
    </form>
</body>
</html>
