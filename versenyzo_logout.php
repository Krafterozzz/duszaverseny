<?php
session_start();
header('Content-Type: application/json');

// Töröljük az összes session változót
$_SESSION = array();

// Töröljük a session cookie-t
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Végül, töröljük a session-t
session_destroy();

echo json_encode(["success" => true, "message" => "Sikeres kijelentkezés!"]);
?>