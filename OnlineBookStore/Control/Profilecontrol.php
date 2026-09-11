<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
} 

require_once("../Model/db.php"); 

$userData = [];
if (isset($_SESSION['user_id'])) {
    $dbObj = new db(); 
    $connObj = $dbObj->openConn(); 
    $userId = $_SESSION['user_id']; 

    $userStmt = $connObj->prepare("SELECT * FROM users_info WHERE id = ?");
    $userStmt->bind_param("i", $userId);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userData = $userResult->fetch_assoc() ?? [];
    $userStmt->close();
    $connObj->close();
}

if (isset($_POST['update_profile'])) {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) { 
        echo json_encode(["status" => "error", "message" => "Unauthorized access! Please login."]);
        exit(); 
    } 

    $dbObj = new db(); 
    $connObj = $dbObj->openConn(); 
    $userId = $_SESSION['user_id']; 

    $userStmt = $connObj->prepare("SELECT * FROM users_info WHERE id = ?");
    $userStmt->bind_param("i", $userId);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userData = $userResult->fetch_assoc();
    $userStmt->close();

    $name = trim($_POST['name'] ?? ''); 
    $email = trim($_POST['email'] ?? ''); 
    $phone = trim($_POST['phone'] ?? ''); 
    $address = trim($_POST['address'] ?? ''); 
    $currPass = $_POST['curr_pass'] ?? ''; 
    $newPass = $_POST['new_pass'] ?? ''; 

    if (empty($name) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "Name and Email are required!"]);
        $connObj->close();
        exit();
    }

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) { 
        $fileTmpPath = $_FILES['profile_pic']['tmp_name']; 
        $fileName = $_FILES['profile_pic']['name']; 
        $fileSize = $_FILES['profile_pic']['size']; 
        $fileType = $_FILES['profile_pic']['type']; 

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg']; 
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); 
        $allowedExtensions = ['jpg', 'jpeg', 'png']; 

        if (in_array($fileType, $allowedMimeTypes) && in_array($fileExtension, $allowedExtensions) && $fileSize <= 2000000) { 
            $newFileName = "profile_" . $userId . "_" . time() . "." . $fileExtension; 
            $uploadFileDir = "../uploads/"; 

            if (!is_dir($uploadFileDir)) { 
                mkdir($uploadFileDir, 0755, true); 
            } 

            $dest_path = $uploadFileDir . $newFileName; 

            if (move_uploaded_file($fileTmpPath, $dest_path)) { 
                $imgStmt = $connObj->prepare("UPDATE users_info SET profile_picture = ? WHERE id = ?"); 
                $imgStmt->bind_param("si", $newFileName, $userId); 
                $imgStmt->execute(); 
                $imgStmt->close(); 
            } 
        } else { 
            echo json_encode(["status" => "error", "message" => "Invalid image file format or size exceeds 2MB!"]);
            $connObj->close();
            exit();
        } 
    } 

    $updateStmt = $connObj->prepare("UPDATE users_info SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?"); 
    $updateStmt->bind_param("ssssi", $name, $email, $phone, $address, $userId); 
    
    if ($updateStmt->execute()) { 
        $_SESSION['name'] = $name; 
        $responseMessage = "Profile updated successfully!"; 
        
        if (!empty($newPass)) { 
            if (password_verify($currPass, $userData['password']) || $currPass === $userData['password']) { 
                if (strlen($newPass) >= 8) { 
                    $hashedPassword = password_hash($newPass, PASSWORD_BCRYPT); 
                    
                    $passStmt = $connObj->prepare("UPDATE users_info SET password = ? WHERE id = ?"); 
                    $passStmt->bind_param("si", $hashedPassword, $userId); 
                    $passStmt->execute(); 
                    $passStmt->close(); 

                    $responseMessage = "Profile and password updated successfully!"; 
                } else { 
                    echo json_encode(["status" => "error", "message" => "New password must be at least 8 characters."]);
                    $updateStmt->close();
                    $connObj->close();
                    exit();
                } 
            } else { 
                echo json_encode(["status" => "error", "message" => "Current password is incorrect!"]);
                $updateStmt->close();
                $connObj->close();
                exit();
            } 
        }

        echo json_encode(["status" => "success", "message" => $responseMessage]);
    } else { 
        echo json_encode(["status" => "error", "message" => "Failed to update profile."]);
    }    

    $updateStmt->close(); 
    $connObj->close(); 
    exit();
} 
?>