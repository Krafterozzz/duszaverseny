<?php
session_start();
header('Content-Type: application/json');

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

    $sql = "SELECT * FROM applications WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['team_name'] = $row['team_name'];
            echo json_encode(["success" => true, "message" => "Sikeres bejelentkezés!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Hibás jelszó!"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Felhasználó nem található!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Érvénytelen kérés típus."]);
}

$conn->close();
?>