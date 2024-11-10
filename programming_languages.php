<?php
// MySQL kapcsolat létrehozása
$servername = "localhost";
$username = "dusza"; // Adja meg a megfelelő felhasználónevet
$password = "y@f9Tu7hx2rMBXG4"; // Adja meg a megfelelő jelszót
$dbname = "duszadb"; // Az adatbázis neve

// Csatlakozás az adatbázishoz
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük a kapcsolatot
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Programnyelvek lekérdezése
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM `programming_languages` ORDER BY `language_name` ASC";
    $result = $conn->query($sql);

    $programming_languages = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $programming_languages[] = $row;
        }
    }

    echo json_encode([
        'success' => true,
        'programming_languages' => $programming_languages
    ]);
} 

// Új programnyelv hozzáadása
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $language_name = $_POST['language_name'];

    if (!empty($language_name)) {
        $stmt = $conn->prepare("INSERT INTO `programming_languages` (`language_name`) VALUES (?)");
        $stmt->bind_param("s", $language_name);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => "Programnyelv sikeresen hozzáadva."
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "Hiba történt a programnyelv hozzáadása során."
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => "A programnyelv neve nem lehet üres."
        ]);
    }
}

// Kapcsolat lezárása
$conn->close();
?>
