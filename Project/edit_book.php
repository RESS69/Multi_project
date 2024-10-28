<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("localhost", "root", "12345678", "mybookdb");


$bookId = $_GET['id'];

$result = $conn->query("SELECT * FROM book WHERE BookID = '$bookId'");
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookName = $_POST['bookName'];
    $bookPrice = $_POST['bookPrice'];
    $status = $_POST['status'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    $updateSql = "UPDATE book SET BookName='$bookName', BookPrice='$bookPrice', Author='$author', Genre='$genre', Status='$status' WHERE BookID='$bookId'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Book details updated successfully.";
        header("Location: Admin.php"); 
        exit();
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Edit Book</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="bookName" class="form-label">Book Name</label>
            <input type="text" name="bookName" class="form-control" value="<?= $book['BookName'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookPrice" class="form-label">Book Price</label>
            <input type="number" name="bookPrice" class="form-control" value="<?= $book['BookPrice'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="<?= $book['Author'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" name="genre" class="form-control" value="<?= $book['Genre'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="available" <?= ($book['Status'] == 'available') ? 'selected' : '' ?>>Available</option>
                <option value="booked" <?= ($book['Status'] == 'booking') ? 'selected' : '' ?>>Booking</option>
                <option value="borrowed" <?= ($book['Status'] == 'borrowed') ? 'selected' : '' ?>>Borrowed</option>
                <option value="sold" <?= ($book['Status'] == 'sold') ? 'selected' : '' ?>>Sold</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="Admin.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
