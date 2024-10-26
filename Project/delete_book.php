<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];


    $sql = "DELETE FROM book WHERE BookID = ?";
    

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $bookId);

        if ($stmt->execute()) {

            echo "Book deleted successfully.";
            header("Location: Admin.php?message=Book deleted successfully");
        } else {

            echo "Error deleting car: " . $conn->error;
        }
        
        $stmt->close();
    }
}
$conn->close();
?>
