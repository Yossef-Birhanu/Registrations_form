<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hardcoded credentials for demo purposes
    $username = "admin";
    $password = "Josi@2018Upto2019";  // Change this to a secure password

    // Authenticate the user
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $loginError = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 0.5rem;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <?php if (isset($loginError)): ?>
        <p class="error"><?php echo $loginError; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="text" name="username" required placeholder="Username">
        <input type="password" name="password" required placeholder="Password">
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>