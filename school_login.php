<?php
session_start();

// Az adatbázis kapcsolat beállításai
$servername = "localhost";
$db_username = "dusza";
$db_password = "y@f9Tu7hx2rMBXG4";
$dbname = "duszadb";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Kapcsolódási hiba: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $input_password_hash = hash('sha256', $password);

        if ($input_password_hash === $hashed_password) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['is_logged_in'] = true;

            // Átirányítás az admin profil oldalra, és bejelentkezési állapot tárolása a localStorage-ben
            echo "<script>localStorage.setItem('is_logged_in', 'true'); window.location.href = 'admin_profile.html';</script>";
        } else {
            echo "<script>alert('Hibás jelszó!'); window.location.href = 'admin_login.html';</script>";
        }
    } else {
        echo "<script>alert('Felhasználó nem található!'); window.location.href = 'admin_login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
