<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

if (!$conn) {
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit();
}

$email = isset($_GET['email']) ? $_GET['email'] : null;

if (!$email) {
    echo json_encode(['error' => 'Email parameter is missing']);
    exit();
}

$sql1 = "SELECT `mbti_type` FROM `felhasznalok` WHERE `user_email` = ?";
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    echo json_encode(['error' => 'Failed to prepare the SQL query']);
    exit();
}

$stmt1->bind_param('s', $email);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows === 0) {
    echo json_encode(['error' => 'No user found with the given email']);
    $stmt1->close();
    mysqli_close($conn);
    exit();
}

$row1 = $result1->fetch_assoc();
$mbti_type = $row1['mbti_type'];
$stmt1->close();

$sql2 = "SELECT `group`, `role`, `description` FROM `mbti` WHERE `mbti_type` LIKE ?";
$stmt2 = $conn->prepare($sql2);

if (!$stmt2) {
    echo json_encode(['error' => 'Failed to prepare the second SQL query']);
    exit();
}

$mbti_query = $mbti_type . '%';
$stmt2->bind_param('s', $mbti_query);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows > 0) {
    $mbti_details = $result2->fetch_assoc();
    echo json_encode([
        'type' => $mbti_type,
        'group' => $mbti_details['group'],
        'role' => $mbti_details['role'],
        'description' => $mbti_details['description']
    ]);
} else {
    echo json_encode(['error' => 'No MBTI details found for the given type']);
}

$stmt2->close();
mysqli_close($conn);
?>
