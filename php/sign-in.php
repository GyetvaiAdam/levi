<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (empty($data["email"]) || empty($data["password"])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Email and password are required.",
    ]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "16szemelyiseg");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to connect to the database.",
    ]);
    exit();
}

$email = $data["email"];
$password = password_hash($data["password"], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO `felhasznalok_adatai` (`user_email`, `user_password`) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "User registered successfully.",
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to register user.",
    ]);
}

$stmt->close();
$conn->close();
?>
