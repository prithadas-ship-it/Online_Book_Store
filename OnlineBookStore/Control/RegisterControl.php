<?php
ob_start();
header('Content-Type: application/json'); 
require_once('../Model/db.php');

$response = [
    "status" => "error",
    "message" => "Invalid Request"
];

if (isset($_REQUEST["mysubmit"])) {

    $name = trim($_REQUEST["name"] ?? "");
    $email = trim($_REQUEST["email"] ?? "");
    $userPassword = $_REQUEST["password"] ?? $_REQUEST["pass"] ?? "";
    $confirmPassword = $_REQUEST["confirm_password"] ?? $_REQUEST["cpass"] ?? "";
    $address = trim($_REQUEST["address"] ?? "");
    $phone = trim($_REQUEST["phone"] ?? "");
    $role = $_REQUEST["role"] ?? "";

    if (empty($name) || empty($email) || empty($userPassword) || empty($address) || empty($phone) || empty($role)) {
        $response["message"] = "All fields are required!";
        echo json_encode($response);
        exit();
    }

    if (strlen($userPassword) < 8) {
        $response["message"] = "Password must be at least 8 characters long!";
        echo json_encode($response);
        exit();
    }

    if ($userPassword !== $confirmPassword) {
        $response["message"] = "Passwords do not match!";
        echo json_encode($response);
        exit();
    }

    $dbObj = new db();
    $connObj = $dbObj->openConn();
    
    $userInsert = $dbObj->insertUser(
        $connObj,
        $name,
        $email,
        $userPassword,
        $address,
        $phone,
        $role
    );

    if ($userInsert) {
        $response["status"] = "success";
        $response["message"] = "Registration Successful! Redirecting to login...";
    } else {
        $response["message"] = "Database Error: " . $connObj->error;
    }

    $connObj->close();
}

ob_end_clean();

echo json_encode($response);
exit();
?>