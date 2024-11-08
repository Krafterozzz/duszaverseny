<?php
function submitApplication($formData) {
    $servername = "localhost";
    $username = "dusza";
    $password = "y@f9Tu7hx2rMBXG4";
    $dbname = "duszadb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return ["success" => false, "message" => "Kapcsolódási hiba: " . $conn->connect_error];
    }

    $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO applications (username, password, team_name, school_name, 
        team_member1_name, team_member1_grade, team_member2_name, team_member2_grade, 
        team_member3_name, team_member3_grade, substitute_member_name, substitute_member_grade, 
        teacher, category, programming_language)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssss", 
        $formData['username'], $hashedPassword, $formData['team_name'], $formData['school_name'], 
        $formData['team_member1_name'], $formData['team_member1_grade'], 
        $formData['team_member2_name'], $formData['team_member2_grade'], 
        $formData['team_member3_name'], $formData['team_member3_grade'], 
        $formData['substitute_member_name'], $formData['substitute_member_grade'], 
        $formData['teacher'], $formData['category'], $formData['programming_language']
    );

    if ($stmt->execute()) {
        $result = ["success" => true, "message" => "Sikeres jelentkezés!"];
    } else {
        $result = ["success" => false, "message" => "Hiba történt: " . $stmt->error];
    }

    $stmt->close();
    $conn->close();

    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = submitApplication($_POST);
    echo json_encode($result);
}
?>