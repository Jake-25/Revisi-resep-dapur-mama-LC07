<?php
session_start(); 


require('./connection.php');

$_SESSION["username"] = $dbUsername;

function getUserDataBySession($sessionUsername) {
    global $conn; 
    $stmt = $conn->prepare("SELECT id, username, password, email, session_id FROM users WHERE username=?");
    $stmt->bind_param("s", $sessionUsername);
    $stmt->execute();
    $stmt->bind_result($userId, $dbUsername, $dbPassword, $dbEmail, $storedSessionId);
    $stmt->fetch();
    $stmt->close();

    
    if ($dbUsername) {
        $userData = array(
            'id' => $userId,
            'username' => $dbUsername,
            'email' => $dbEmail,
        );
        return $userData;
    } else {
        return null;
    }
}