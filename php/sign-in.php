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

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Internal Server Error.",
    ]);
    exit();
}

$email = $data["email"];
$password = $data["password"];

$stmt = $conn->prepare("SELECT `user_email`, `user_password` FROM `felhasznalok_adatai` WHERE `user_email` = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    error_log("Invalid email: " . $email);
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password.",
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
if (password_verify($password, $row['user_password'])) {
    echo json_encode([
        "status" => "success",
        "message" => "Login successful.",
    ]);
}

$stmt->close();
$conn->close();
?>
