<?php
session_start();
require_once("../Control/Homecontrol.php");

$homeCtrl = new Homecontrol();
$bookResult = $homeCtrl->getFeaturedBooksData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookHaven - Your World. Your Books.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/Home.css">
</head>
<body>

    <header class="navbar">
        <a href="home.php" class="logo-container">
            <i class="fa-solid fa-book-open logo-icon"></i>
            <div>
                <div class="logo-text">Book<span>Haven</span></div>
                <div class="tagline">Your World. Your Books.</div>
            </div>
        </a>

        <nav class="nav-links">
            <a href="home.php" class="active"><i class="fa-solid fa-house"></i> Home</a>
            <a href="Browse.php"><i class="fa-solid fa-book-open"></i> Browse Books</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="Profile.php"><i class="fa-regular fa-user"></i> My Profile</a>
            <?php else: ?>
                <a href="Login.php"><i class="fa-regular fa-user"></i> My Profile</a>
            <?php endif; ?>
        </nav>

        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../Control/LogoutControl.php" class="btn-outline">Logout</a>
            <?php else: ?>
                <a href="Login.php" class="btn-outline">Login</a>
                <a href="Register.php" class="btn-primary">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="hero">
        <button class="slider-arrow prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-arrow next-btn"><i class="fa-solid fa-chevron-right"></i></button>

        <div class="hero-content">
            <span class="badge">WELCOME TO BOOKHAVEN</span>
            <h1>Find Your Next <br><span>Great Read</span></h1>
            <p>Explore thousands of books across all genres.<br>Find stories that inspire, educate, and entertain.</p>
            <div class="hero-btns">
                <a href="Browse.php" class="btn-primary">Browse Books &rarr;</a>
                <a href="Browse.php" class="btn-outline-hero">Learn More</a>
            </div>
        </div>

        <div class="hero-image-container">
            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1000&auto=format&fit=crop" alt="Hero Bookshelf" class="hero-img">
        </div>

        <div class="slider-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>

    <section class="section featured-section">
        <div class="section-header">
            <div class="title-wrap">
                <h2 class="section-title">Featured Books</h2>
                <div class="decorative-line"><span>★</span></div>
            </div>
            <a href="Browse.php" class="view-all">View All <i class="fa-solid fa-chevron-right"></i></a>
        </div>

        <div class="books-grid">
            <?php if ($bookResult && $bookResult->num_rows > 0): ?>
                <?php while ($book = $bookResult->fetch_assoc()): ?>
                    <a href="BookDetails.php?id=<?php echo $book['id']; ?>" class="book-card">
                        <div class="book-cover">
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
                        <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="book-author"><?php echo htmlspecialchars($book['author']); ?></div>
                        <div class="book-rating">
                            <i class="fa-solid fa-star"></i> <?php echo isset($book['rating']) ? htmlspecialchars($book['rating']) : '4.5'; ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="book-card">
                    <div class="book-cover"><img src="../Images/the alchemist.jpg" alt="Book"></div>
                    <div class="book-title">The Alchemist</div>
                    <div class="book-author">Paulo Coelho</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.6</div>
                </div>
                <div class="book-card">
                    <div class="book-cover"><img src="../Images/atomic habits.webp" alt="Book"></div>
                    <div class="book-title">Atomic Habits</div>
                    <div class="book-author">James Clear</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.7</div>
                </div>
                <div class="book-card">
                    <div class="book-cover"><img src="../Images/the hobbit.jpg" alt="Book"></div>
                    <div class="book-title">The Hobbit</div>
                    <div class="book-author">J.R.R. Tolkien</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.8</div>
                </div>
                <div class="book-card">
                    <div class="book-cover"><img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400" alt="Book"></div>
                    <div class="book-title">Verity</div>
                    <div class="book-author">Colleen Hoover</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.6</div>
                </div>
                <div class="book-card">
                    <div class="book-cover"><img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400" alt="Book"></div>
                    <div class="book-title">The Silent Patient</div>
                    <div class="book-author">Alex Michaelides</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.5</div>
                </div>
                <div class="book-card">
                    <div class="book-cover"><img src="https://images.unsplash.com/photo-1592496001020-d31bd830651f?w=400" alt="Book"></div>
                    <div class="book-title">The Psychology of Money</div>
                    <div class="book-author">Morgan Housel</div>
                    <div class="book-rating"><i class="fa-solid fa-star"></i> 4.7</div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="home.php" class="logo-container light-logo">
                    <i class="fa-solid fa-book-open logo-icon"></i>
                    <div class="logo-text">Book<span>Haven</span></div>
                </a>
                <p class="tagline-sub">Your World. Your Books.</p>
                <p class="brand-desc">BookHaven is your ultimate online bookstore. Discover, purchase, and enjoy books from anywhere, anytime.</p>
            </div>

            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="Browse.php">Browse Books</a></li>
                    <li><a href="Profile.php">My Profile</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Customer Service</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping & Delivery</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Stay Connected</h4>
                <p class="connected-text">Get the latest updates and offers.</p>
                <form class="newsletter-form" onsubmit="return subscribeNewsletter(event)">
                    <input type="email" id="newsletterEmail" placeholder="Enter your email" class="newsletter-input" required>
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© <?php echo date("Y"); ?> BookHaven. All rights reserved.</div>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <script src="../JS/home.js"></script>
</body>
</html>