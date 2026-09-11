<?php
require_once("../Model/db.php");

class Browsecontrol {
    public function getBooksData($categoryId = null, $search = null) {
        $dbObj = new db();
        $connObj = $dbObj->openConn();

        $result = $dbObj->getBooksByCategory($connObj, $categoryId, $search);
        $books = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }

        $connObj->close();
        return $books;
    }
}

if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    header('Content-Type: application/json');

    $categoryId = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? intval($_GET['category_id']) : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;

    $ctrl = new Browsecontrol();
    $books = $ctrl->getBooksData($categoryId, $search);

    $html = "";
    if (count($books) > 0) {
        foreach ($books as $book) {
            $imgPath = !empty($book['image_path']) ? trim($book['image_path']) : '';
            if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                $finalSrc = $imgPath;
            } elseif (!empty($imgPath)) {
                $finalSrc = "../Images/" . basename($imgPath);
            } else {
                $finalSrc = "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400";
            }

            $rating = isset($book['rating']) ? $book['rating'] : '4.5';

            $html .= '
            <a href="BookDetails.php?id=' . $book['id'] . '" class="book-card">
                <div class="book-image-wrapper">
                    <img src="' . htmlspecialchars($finalSrc) . '" alt="' . htmlspecialchars($book['title']) . '">
                </div>
                <h3 class="book-title">' . htmlspecialchars($book['title']) . '</h3>
                <p class="book-author">' . htmlspecialchars($book['author']) . '</p>
                <div class="book-rating">
                    <span class="star-icon">★</span> ' . htmlspecialchars($rating) . '
                </div>
            </a>';
        }
        echo json_encode(["status" => "success", "html" => $html]);
    } else {
        echo json_encode(["status" => "empty"]);
    }
    exit();
}
?>