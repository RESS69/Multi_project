<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrowId = $_POST['borrow_id'];
    $bookId = $_POST['book_id'];

    $sql = "UPDATE Borrowing SET ReturnDate=CURDATE(), Status='returned' WHERE BorrowingID='$borrowId'";
    $conn->query($sql);
    $conn->query("UPDATE book SET Status='available' WHERE BookID='$bookId'");

    header('Location: User.php');
}
?>
