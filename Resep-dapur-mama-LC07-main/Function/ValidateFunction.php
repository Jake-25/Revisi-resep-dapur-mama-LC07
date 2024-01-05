<?php

function cleanInput($input) {

    $input = trim($input);
    
    $input = strip_tags($input);
    
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    return $input;
}


function validateUsername($username) {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
    return preg_match($pattern, $username);
}

function validatePassword($password) {
    return strlen($password) >= 8;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

?>