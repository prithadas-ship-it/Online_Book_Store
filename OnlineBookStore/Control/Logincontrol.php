<?php
session_start();
header('Content-Type: application/json');
require_once("../Model/db.php");

$response = [
    "status" => "error",
    "message" => "Invalid Request"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $response["message"] = "Please fill in all fields.";
        echo json_encode($response);
        exit();
    }

    $dbObj = new db();
    $conn = $dbObj->openConn();

    $result = $dbObj->loginUser($conn, $email);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $passMatch = false;
        if (isset($user['password_hash'])) {
            $passMatch = password_verify($password, $user['password_hash']);
        } elseif (isset($user['password'])) {
            $passMatch = password_verify($password, $user['password']) || ($password === $user['password']);
        }

        if ($passMatch) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            $response["status"] = "success";
            $response["redirect"] = "../View/Home.php";
        } else {
            $response["message"] = "Invalid Password!";
        }
    } else {
        $response["message"] = "User not found with this email!";
    }

    $conn->close();
}

echo json_encode($response);
exit();
?>