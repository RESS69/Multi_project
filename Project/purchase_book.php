<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $bookId = $_POST['book_id'];
    $purchaseDate = date('Y-m-d');
    $amount = $_POST['amount'];  

    $sql = "INSERT INTO Purchases (UserID, BookID, PurchaseDate, Amount) VALUES ('$userId', '$bookId', '$purchaseDate', '$amount')";
    $conn->query($sql);
    $conn->query("UPDATE book SET Status='sold' WHERE BookID='$bookId'");

    header('Location: User.php');
}
?>
