<?php
class db {
    private $dbhost = "localhost";
    private $dbuser = "root";
    private $dbpass = "";
    private $dbname = "OnlineBookStore";

    public function openConn() {
        $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }


    function insertUser($conn, $name, $email, $password, $address, $phone, $role) {

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare(
            "INSERT INTO users_info 
            (name, email, password_hash, address, phone, role) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssss",
            $name,
            $email,
            $hashedPassword,
            $address,
            $phone,
            $role
        );

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }


    function loginUser($conn, $email) {

        $stmt = $conn->prepare(
            "SELECT * FROM users_info WHERE email = ?"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        return $result;
    }


    public function getCategories($conn) {

        return $conn->query(
            "SELECT * FROM categories ORDER BY name ASC"
        );
    }


    public function getAllBooks($conn) {

        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories 
                ON books.category_id = categories.id
                ORDER BY books.id DESC";

        return $conn->query($sql);
    }


    public function getFeaturedBooks($conn) {

    $sql = "SELECT * FROM books LIMIT 6"; 
   
    
    return $conn->query($sql);
}


    public function getBooksByCategory($conn, $categoryId = null, $search = null) {
        $sql = "SELECT * FROM books WHERE 1=1";
    $params = [];
    $types = "";

      if ($categoryId !== null) {
        $sql .= " AND category_id = ?";
        $params[] = $categoryId;
        $types .= "i";
    }

    if (!empty($search)) {
        $sql .= " AND (title LIKE ? OR author LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "ss";
    }

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
  
    }
}

?>