<?php
session_start(); // Start a session to manage user login state
include("config.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($email) && !empty($password)) {
        // Sanitize email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Fetch user data from the database
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            // Check if the email exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $db_email, $db_password);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $db_password)) {
                    // Login successful
                    $_SESSION['user_id'] = $id; // Store user ID in session
                    $_SESSION['email'] = $db_email; // Store email in session
                    session_regenerate_id(true); // Regenerate session ID for security
                    header("Location: dashboard.php"); // Redirect to dashboard
                    exit;
                } else {
                    $error_message = "Invalid email or password.";
                }
            } else {
                $error_message = "Invalid email or password.";
            }

            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $conn->error;
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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

        .inner {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .sep {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        label {
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }

        .feedback {
            margin-top: 20px;
            text-align: center;
            color: #d9534f;
        }
    </style>
</head>
<body>

    <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="inner">
            <div class="sep">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="titlechange">Login</button>
        </div>
    </form>

    <!-- Feedback Container -->
    <div class="feedback">
        <?php
        if (isset($error_message)) {
            echo "<p>$error_message</p>";
        }
        ?>
    </div>

</body>
</html>