<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("localhost", "root", "12345678", "mybookdb");


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = $searchTerm ? "WHERE BookName LIKE '%$searchTerm%' OR Genre LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%'" : '';


$books = $conn->query("SELECT * FROM book $searchCondition ORDER BY CASE WHEN BookName LIKE '%$searchTerm%' THEN 1 ELSE 2 END, BookName");


$bookings = $conn->query("SELECT * FROM Bookings JOIN book ON Bookings.BookID = book.BookID");
$borrowings = $conn->query("SELECT * FROM Borrowing JOIN book ON Borrowing.BookID = book.BookID");
$purchases = $conn->query("SELECT * FROM Purchases JOIN book ON Purchases.BookID = book.BookID");
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: orange;
        }
        .dashboard-header {
            margin-top: 20px;
            text-align: center;
        }
        .section-title {
            margin-top: 40px;
            margin-bottom: 20px;
            color: #343a40;
        }
        .table-section {
            margin-bottom: 40px;
        }
        .btn-primary, .btn-warning, .btn-danger {
            margin: 5px;
        }
        .logout-btn {
            float: right;
        }
        .table {
            border: 4px solid black;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
    </div>

    <!-- ค้นหา -->
    <form method="GET" class="search-bar">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Book Name" value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="btn btn-primary">: Search</button>
        </div>
    </form>

    <!--จัดการข้อมูล -->
    <div class="table-section">
        <h2 class="section-title">Manage Books</h2>
        <a href="add_book.php" class="btn btn-primary">Add New Book</a>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>BookID</th>
                    <th>BookName</th>
                    <th>BookPrice</th>
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
                    <td><?= ucfirst($book['Status']) ?></td>
                    <td>
                        <a href="edit_book.php?id=<?= $book['BookID'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_book.php?id=<?= $book['BookID'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- จอง -->
    <div class="table-section">
        <h2 class="section-title">View Bookings</h2>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>BookingID</th>
                    <th>BookName</th>
                    <th>BookingDate</th>
                    <th>UserID</th>
                </tr>
            </thead>
            <tbody>
                <?php while($booking = $bookings->fetch_assoc()) { ?>
                <tr>
                    <td><?= $booking['BookingID'] ?></td>
                    <td><?= $booking['BookName'] ?></td>
                    <td><?= $booking['BookingDate'] ?></td>
                    <td><?= $booking['UserID'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- ยืม -->
    <div class="table-section">
        <h2 class="section-title">View Borrowings</h2>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>BorrowingID</th>
                    <th>BookName</th>
                    <th>BorrowDate</th>
                    <th>ReturnDate</th>
                    <th>UserID</th>
                </tr>
            </thead>
            <tbody>
                <?php while($borrow = $borrowings->fetch_assoc()) { ?>
                <tr>
                    <td><?= $borrow['BorrowingID'] ?></td>
                    <td><?= $borrow['BookName'] ?></td>
                    <td><?= $borrow['BorrowDate'] ?></td>
                    <td><?= $borrow['ReturnDate'] ?></td>
                    <td><?= $borrow['UserID'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- ซื้อ -->
    <div class="table-section">
        <h2 class="section-title">View Purchases</h2>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>PurchaseID</th>
                    <th>BookName</th>
                    <th>PurchaseDate</th>
                    <th>UserID</th>
                </tr>
            </thead>
            <tbody>
                <?php while($purchase = $purchases->fetch_assoc()) { ?>
                <tr>
                    <td><?= $purchase['PurchaseID'] ?></td>
                    <td><?= $purchase['BookName'] ?></td>
                    <td><?= $purchase['PurchaseDate'] ?></td>
                    <td><?= $purchase['UserID'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
