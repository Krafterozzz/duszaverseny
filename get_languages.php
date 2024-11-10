<?php
// get_languages.php
header('Content-Type: application/json');

$servername = "localhost";
$db_username = "dusza";
$db_password = "y@f9Tu7hx2rMBXG4";
$dbname = "duszadb";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Kapcsolódási hiba: " . $conn->connect_error
    ]);
    exit;
}

$conn->set_charset("utf8mb4");

$sql = "SELECT * FROM programming_languages ORDER BY name";
$result = $conn->query($sql);

if ($result) {
    $languages = [];
    while ($row = $result->fetch_assoc()) {
        $languages[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
    
    echo json_encode([
        "success" => true,
        "languages" => $languages
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Hiba történt a programnyelvek lekérése során: " . $conn->error
    ]);
}

$conn->close();
?>
