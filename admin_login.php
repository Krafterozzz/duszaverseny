<?php
session_start();

// Az adatbázis kapcsolat beállításai
$servername = "localhost";
$db_username = "dusza";
$db_password = "y@f9Tu7hx2rMBXG4";
$dbname = "duszadb";

// Kapcsolódás az adatbázishoz
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Kapcsolódási hiba: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");

// Ha POST kérést kapunk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // A felhasználó által megadott felhasználónév és jelszó
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL lekérdezés, hogy megtaláljuk a felhasználót
    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ha találunk olyan felhasználót, aki egyezik a megadott névvel
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Ellenőrizzük, hogy a jelszó megfelelő-e (hashelve van)
        // Feltételezve, hogy a jelszó SHA-256 hashelve van az adatbázisban
        $hashed_password = $row['password'];
        $input_password_hash = hash('sha256', $password);  // Jelszó hashelése a bejelentkezéskor

        if ($input_password_hash === $hashed_password) {
            // Bejelentkezés sikeres, elmentjük a felhasználói adatokat
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Role oszlop hozzáadása, ha szükséges
            $_SESSION['is_logged_in'] = true; // Jelzés, hogy be van jelentkezve

            // Átirányítás az admin profil oldalra
            echo "<script>sessionStorage.setItem('is_logged_in', 'true'); window.location.href = 'admin_profile.html';</script>";
        } else {
            // Hibás jelszó
            echo json_encode(["success" => false, "message" => "Hibás jelszó!"]);
        }
    } else {
        // Ha a felhasználó nem található
        echo json_encode(["success" => false, "message" => "Felhasználó nem található!"]);
    }

    // Lekérdezés lezárása
    $stmt->close();
} else {
    // Ha nem POST kérés érkezik
    echo json_encode(["success" => false, "message" => "Érvénytelen kérés típus."]);
}

// Adatbázis kapcsolat bezárása
$conn->close();
?>
