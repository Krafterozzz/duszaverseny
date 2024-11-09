<?php
// Adatbázis kapcsolódási adatok
$servername = "localhost"; // Adatbázis szerver
$username = "dusza"; // Felhasználónév
$password = "y@f9Tu7hx2rMBXG4"; // Jelszó
$dbname = "duszadb"; // Az adatbázis neve

// Kapcsolódás az adatbázishoz
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolódás ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Beállítjuk a karakterkódolást, hogy UTF-8-at használjunk az adatbázissal való kommunikációban
$conn->set_charset("utf8mb4");

?>
