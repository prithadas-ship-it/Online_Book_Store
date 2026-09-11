<?php
session_start();
require_once("../Control/Browsecontrol.php");
require_once("../Control/Browsecontrol.php");

$dbObj = new db();
$connObj = $dbObj->openConn();

$categories = $connObj->query("SELECT * FROM categories");

$categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? intval($_GET['category_id']) : null;

$browseCtrl = new Browsecontrol();
$books = $browseCtrl->getBooksData($categoryId);

$connObj->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books - BookHaven</title>
    <link rel="stylesheet" href="../CSS/Browse.css">
</head>

<body>

<div class="navbar">
    <a href="Home.php" class="logo">BookHaven</a>

    <div class="nav-links">
        <a href="Home.php">Home</a>
        <a href="Browse.php">Browse Books</a>
        <a href="Profile.php">Profile</a>
        <a href="../Control/LogoutControl.php">Logout</a>
    </div>
</div>
  </div>
<div class="search-container" style="text-align: center; margin: 20px 0;">
    <input type="text" id="searchBox" placeholder="Search books by title or author..." style="padding: 10px; width: 50%; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
</div>

<div class="books-grid" id="booksGrid">
</div>
<div class="container">

    <h2 class="section-title">
        Browse Categories <span class="star-sparkle">✦</span>
    </h2>

    <br>

    <div class="category-pills">

        <a href="Browse.php"
           class="category-btn <?php echo ($categoryId === null) ? 'active' : ''; ?>">
            All Categories
        </a>

        <?php while ($cat = $categories->fetch_assoc()): ?>

            <a href="Browse.php?category_id=<?php echo $cat['id']; ?>"
               class="category-btn <?php echo ($categoryId == $cat['id']) ? 'active' : ''; ?>">

                <?php echo htmlspecialchars($cat['name']); ?>

            </a>

        <?php endwhile; ?>

    </div>


    <div class="section-header">

        <h2 class="section-title">
            Featured Books <span class="star-sparkle">✦</span>
        </h2>

        <a href="#" class="view-all-btn">View All &gt;</a>

    </div>


    <div id="book-list" class="book-grid">

        <?php if (count($books) == 0): ?>

            <p>No books found in this category.</p>

        <?php else: ?>

            <?php foreach ($books as $book): ?>

                <div class="book-card">

                    <div class="book-image-wrapper">

                        <?php
                            $imgPath = !empty($book['image_path']) ? trim($book['image_path']) : '';

                            if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                                $finalSrc = $imgPath;
                            } elseif (!empty($imgPath)) {
                                $finalSrc = "../Images/" . basename($imgPath);
                            } else {
                                $finalSrc = "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400";
                            }
                        ?>
                        <img src="<?php echo htmlspecialchars($finalSrc); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">

                     </div>

                    <h3 class="book-title">
                        <?php echo htmlspecialchars($book['title']); ?>
                    </h3>

                    <p class="book-author">
                        <?php echo htmlspecialchars($book['author']); ?>
                    </p>

                    <div class="book-rating">
                        <span class="star-icon">★</span> 4.5
                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

<script src="../JS/Browse.js"></script>
</body>
</html>