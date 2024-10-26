<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("localhost", "root", "12345678", "mybookdb");

$userId = $_SESSION['user_id'];

// ค้นหา
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = $searchTerm ? "AND (BookName LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%')" : '';

// ค้นหา
$books = $conn->query("SELECT * FROM book WHERE Status='available' $searchCondition ORDER BY CASE WHEN BookName LIKE '%$searchTerm%' THEN 1 ELSE 2 END, BookName");

?>

<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: orange;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
            border: 4px solid black;
            box-shadow: 0 0 10px #000000;
            backdrop-filter: blur(5px);
        }
        .btn-group .btn {
            margin-right: 5px;
        }
        .table-actions form {
            display: inline;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container dashboard-container">
    <div class="justify-content-between">
        <h1>Welcome, What Kind of Book Would You Like To Buy Today? Let us known!</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- ค้นหา -->
    <form method="GET" class="search-bar">
        <div class="input-group mt-2">
            <input type="text" name="search" class="form-control" placeholder="Search by Book Name, Genre, or Author" value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Available Books -->
    <div class="card mt-4 border border-dark rounded">
        <div class="card-header">
            <h2>Available Books</h2>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>BookID</th>
                        <th>Book Name</th>
                        <th>Book Price</th>
                        <th>Genre</th> 
                        <th>Author</th>   
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($book = $books->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $book['BookID'] ?></td>
                        <td><?= $book['BookName'] ?></td>
                        <td>$<?= number_format($book['BookPrice'], 2) ?></td>
                        <td><?= $book['Genre'] ?></td>
                        <td><?= $book['Author'] ?></td>
                        <td><span class="badge bg-success"><?= ucfirst($book['Status']) ?></span></td>
                        <td class="table-actions">
                            <div class="btn-group" role="group" aria-label="Actions">
                                <form method="POST" action="book_book.php">
                                    <input type="hidden" name="book_id" value="<?= $book['BookID'] ?>">
                                    <button type="submit" class="btn btn-primary">Book</button>
                                </form>
                                <form method="POST" action="borrow_book.php">
                                    <input type="hidden" name="book_id" value="<?= $book['BookID'] ?>">
                                    <button type="submit" class="btn btn-info">Borrow</button>
                                </form>
                                <form method="POST" action="purchase_book.php">
                                    <input type="hidden" name="book_id" value="<?= $book['BookID'] ?>">
                                    <button type="submit" class="btn btn-success">Purchase</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ยืม -->
    <div class="card mt-5 mb-5 border border-dark rounded">
        <div class="card-header">
            <h2>My Borrowed Books</h2>
        </div>
        <div class="card-body">
            <?php
            $borrowings = $conn->query("SELECT * FROM Borrowing JOIN book ON Borrowing.BookID = book.BookID WHERE Borrowing.UserID='$userId' AND Borrowing.Status='borrowed'");
            if ($borrowings->num_rows > 0) { ?>
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Book ID</th>
                            <th>Borrow Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($borrow = $borrowings->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $borrow['BookID'] ?></td>
                            <td><?= $borrow['BorrowDate'] ?></td>
                            <td>
                                <form method="POST" action="return_book.php">
                                    <input type="hidden" name="borrow_id" value="<?= $borrow['BorrowingID'] ?>">
                                    <input type="hidden" name="book_id" value="<?= $borrow['BookID'] ?>">
                                    <button type="submit" class="btn btn-warning">Return</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No borrowed books at the moment.</p>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
