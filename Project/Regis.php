<!-- user_registration.php -->
<?php
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role = 'user'; // Default role for new registrations

    // Insert user into the database
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
