<?php
session_start();
$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add_book'])) {
    $bookName = $_POST['book_name'];
    $bookPrice = $_POST['book_price'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    $sql = "INSERT INTO book (BookName, BookPrice, Author, Genre) VALUES ('$bookName', '$bookPrice', '$author', '$genre')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Car added successfully!</div>";
        header('Location: Admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<html>
<head>
    <title>Add New Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Add a New Book</h2>
    
    <!-- เพิ่ม หนังสือ -->
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="book_name" class="form-label">Book Name</label>
            <input type="text" name="book_name" class="form-control" placeholder="Enter Book Name" required>
        </div>
        
        <div class="mb-3">
            <label for="book_price" class="form-label">Book Price</label>
            <input type="number" name="book_price" class="form-control" placeholder="Enter Book Price" required>
        </div>
        
        <div class="mb-3">
            <label for="author" class="form-label">author</label>
            <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">genre</label>
            <input type="text" name="genre" class="form-control" placeholder="Enter genre" required>
        </div>

        <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
        <a href="Admin.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
