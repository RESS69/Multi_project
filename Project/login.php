<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['role'] = $user['Role'];

        if ($user['Role'] == 'admin') {
            header('Location: Admin.php'); 
        } else {
            header('Location: User.php');  
        }
    } else {
        $loginError = "Invalid login credentials";
    }
}
?>

<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: orange;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            border: 4px solid black;
            box-shadow: 0 0 10px #000000;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>

        <?php if (isset($loginError)): ?>
            <p class="error-message"><?= $loginError ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
