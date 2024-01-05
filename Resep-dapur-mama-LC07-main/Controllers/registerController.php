<?php

require('../Function/connection.php');
require('../Function/ValidateFunction.php');
require('../Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = cleanInput($_POST["newEmail"]);
    $newUsername = cleanInput($_POST["newUsername"]);
    $newPassword = cleanInput($_POST["newPassword"]);
    $confirmPassword = cleanInput($_POST["confirmPassword"]);

    if (!validateUsername($newUsername)) {
        echo "Username tidak valid. Pastikan username memiliki panjang minimal 8 karakter dan mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.";
    } elseif (!validatePassword($newPassword)) {
        echo "Password harus memiliki panjang minimal 8 karakter.";
    } elseif ($newPassword !== $confirmPassword) {
        echo "Konfirmasi password tidak sesuai.";
    } elseif (!validateEmail($newEmail)) {
        echo "Email tidak valid.";
    } else {

        session_start();


        $newSessionId = generateUniqueSessionId();

 
        $checkExistingQuery = "SELECT * FROM users WHERE email = ? OR username = ?";
        $checkExistingStmt = $conn->prepare($checkExistingQuery);
        $checkExistingStmt->bind_param("ss", $newEmail, $newUsername);
        $checkExistingStmt->execute();
        $checkExistingResult = $checkExistingStmt->get_result();

        if ($checkExistingResult->num_rows > 0) {
 
            echo "Email atau username sudah digunakan. Silakan pilih yang lain.";
        } else {
     
            $encryptedPassword = encryptData($newPassword, $encryptionKey);

    
            $insertQuery = "INSERT INTO users (email, username, password, session_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $newEmail, $newUsername, $encryptedPassword, $newSessionId);

    
            if ($stmt->execute()) {
             
                $_SESSION['username'] = $newUsername; 
                echo "Pendaftaran berhasil! Silakan login.";
                header("Location: ../login.php");
            } else {
        
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }

      
            $stmt->close();
        }

 
        $checkExistingStmt->close();
    }
} else {

    header("Location: ../register.php");
    exit();
}


$conn->close();
?>