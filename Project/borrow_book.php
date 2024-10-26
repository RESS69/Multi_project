<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $bookId = $_POST['book_id'];
    $borrowDate = date('Y-m-d');

    $sql = "INSERT INTO Borrowing (UserID, BookID, BorrowDate, Status) VALUES ('$userId', '$bookId', '$borrowDate', 'borrowed')";
    $conn->query($sql);
    $conn->query("UPDATE book SET Status='borrowed' WHERE BookID='$bookId'");

    header('Location: User.php');
}
?>
