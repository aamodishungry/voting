
<?php
include("config.php");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($password);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "<h1>Error: " . $stmt->error . "</h1>";
        }

        $stmt->close();
    } else {
        echo "<h1>Please fill in all fields.</h1>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
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

        .show-password {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

    <form id="auth-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="inner">
            <div class="sep">
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <label>
                <input type="checkbox" name="age_verification" required>
                I confirm that I am 18 years of age or older.
            </label>
            <div class="show-password">
                <label>
                    <input type="checkbox" id="show-password"> Show Password
                </label>
            </div>
            <button type="submit" name="submit" class="titlechange">Signup</button>
        </div>
    </form>

    <script>
        // Toggle password visibility
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordField = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', () => {
            if (showPasswordCheckbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>

</body>
</html>