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

$updateSql = "UPDATE `felhasznalok` SET `test_count` = `test_count` + 1 WHERE `user_email` = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    // Retrieve the updated `test_count`
    $selectSql = "SELECT `test_count` FROM `felhasznalok` WHERE `user_email` = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("s", $email);
    $selectStmt->execute();
    $result = $selectStmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['test_count' => $row['test_count']]);
    } else {
        echo json_encode(['error' => 'Failed to fetch updated test count']);
    }
} else {
    echo json_encode(['error' => 'Failed to update test count']);
}

$stmt->close();
$conn->close();
?>
