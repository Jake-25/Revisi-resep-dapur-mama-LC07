<?php

// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

// ini_set('log_errors', 1);
// ini_set('error_log', '/Controllers/error.log');

session_start();


require('../Function/connection.php');
require('../Function/ValidateFunction.php');
require('../Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);



    $stmt = $conn->prepare("SELECT id, username, password, session_id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $dbUsername, $dbPassword, $storedSessionId);
    $stmt->fetch();
    $stmt->close();


    if ($dbUsername && ($password == decryptData($dbPassword, $decryptionKey))) {

        if (!empty($storedSessionId) && $storedSessionId !== session_id()) {

            session_destroy();
            echo "You are already logged in from a different device or session. Please log in again.";
        }


        $_SESSION["username"] = $dbUsername;

        session_regenerate_id(true);

        $newSessionId = session_id();


        $updateStmt = $conn->prepare("UPDATE users SET session_id=? WHERE id=?");
        $updateStmt->bind_param("si", $newSessionId, $userId);
        $updateStmt->execute();
        $updateStmt->close();


        header("Location: ../index.php");
        exit();
    } else {
        echo "Login failed. Check your username and password.";
    }

    $conn->close();
}
?>