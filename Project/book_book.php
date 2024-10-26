<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $bookId = $_POST['book_id'];
    $bookingDate = date('Y-m-d');

    $sql = "INSERT INTO Bookings (UserID, BookID, BookingDate) VALUES ('$userId', '$bookId', '$bookingDate')";
    $conn->query($sql);
    $conn->query("UPDATE book SET Status='booking' WHERE BookID='$bookId'");

    header('Location: User.php');
}
?>
