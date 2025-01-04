<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

if (!$conn) {
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit();
}

// Get user email from the request (ensure it's securely passed via the query string)
$email = isset($_GET['email']) ? $_GET['email'] : null;

if (!$email) {
    echo json_encode(['error' => 'Email parameter is missing']);
    exit();
}

// Fetch MBTI type for the user
$sql = "SELECT `mbti_type` FROM `felhasznalok` WHERE `user_email` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No user found with the given email']);
    exit();
}

$row = $result->fetch_assoc();
$mbti_type = $row['mbti_type'];

// Fetch details from the mbti table
$sql = "SELECT `group`, `role`, `description` FROM `mbti` WHERE `mbti_type` LIKE ?";
$stmt = $conn->prepare($sql);
$mbti_query = $mbti_type . '%';
$stmt->bind_param('s', $mbti_query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $mbti_details = $result->fetch_assoc();
    echo json_encode([
        'type' => $mbti_type,
        'group' => $mbti_details['group'],
        'role' => $mbti_details['role'],
        'description' => $mbti_details['description']
    ]);
} else {
    echo json_encode(['error' => 'No MBTI details found for the given type']);
}

// Close the database connection
mysqli_close($conn);
?>
