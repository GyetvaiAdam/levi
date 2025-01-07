<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? null;

if (!$email) {
    echo json_encode(['error' => 'Email is required']);
    exit();
}

$sql = "SELECT `test_count` FROM `felhasznalok` WHERE `user_email` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($test_count);

if ($stmt->fetch()) {
    echo json_encode(['count' => $test_count]);
} else {
    echo json_encode(['count' => null, 'error' => 'Email not found']);
}

$stmt->close();
mysqli_close($conn);
?>
