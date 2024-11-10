<?php
// delete_language.php
header('Content-Type: application/json');

$servername = "localhost";
$db_username = "dusza";
$db_password = "y@f9Tu7hx2rMBXG4";
$dbname = "duszadb";

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Hiányzó programnyelv azonosító!"
    ]);
    exit;
}

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Kapcsolódási hiba: " . $conn->connect_error
    ]);
    exit;
}

$conn->set_charset("utf8mb4");

$id = (int)$data['id'];

// Programnyelv törlése
$sql = "DELETE FROM programming_languages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Programnyelv sikeresen törölve!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Hiba történt a programnyelv törlése során: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>