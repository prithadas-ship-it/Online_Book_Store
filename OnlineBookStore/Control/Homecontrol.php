<?php
require_once("../Model/db.php");

class Homecontrol {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new db();
        $this->conn = $this->db->openConn();
    }

    public function getCategoriesData() {
        return $this->db->getCategories($this->conn);
    }

    public function getFeaturedBooksData() {
        return $this->db->getFeaturedBooks($this->conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'subscribe_newsletter') {
    header('Content-Type: application/json');

    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please provide a valid email address."]);
        exit();
    }

    echo json_encode(["status" => "success", "message" => "Thank you for subscribing to our newsletter!"]);
    exit();
}
?>