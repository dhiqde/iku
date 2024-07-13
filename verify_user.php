<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "avbkiller99!";
$dbname = "it_tickets";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$verification_code = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $verification_code = $conn->real_escape_string($_POST['verification_code']);

    // Validasi bahwa username dan verification_code tidak kosong
    if (!empty($username) && !empty($verification_code)) {
        $sql = "SELECT * FROM users WHERE username='$username' AND verification_token='$verification_code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql_update = "UPDATE users SET verification_token=NULL WHERE username='$username'";
            if ($conn->query($sql_update) === TRUE) {
                $success = "User successfully verified.";
            } else {
                $error = "Error updating record: " . $conn->error;
            }
        } else {
            $error = "Invalid username or verification code.";
        }
    } else {
        $error = "Username and verification code are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .verify-user-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            text-align: center;
        }
        .verify-user-button {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="verify-user-container">
    <h2>Verify User</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="verification_code">Verification Code:</label>
            <input type="text" name="verification_code" id="verification_code" required>
        </div>
        <input type="submit" value="Verify User" class="verify-user-button">
    </form>
</div>

</body>
</html>
