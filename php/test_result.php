<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$conn = new mysqli("localhost", "root", "", "16szemelyiseg");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['responses']) || !isset($data['email'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid data provided"]);
    exit();
}

$responses = $data['responses'];
$email = $data['email'];

// Initialize scores for each dimension
$dimensions = [
    "mind" => 0,     // Extroversion (E) vs. Introversion (I)
    "energy" => 0,   // Intuition (N) vs. Sensing (S)
    "nature" => 0,   // Feeling (F) vs. Thinking (T)
    "tactics" => 0,  // Judging (J) vs. Perceiving (P)
    "identity" => 0  // Assertive (A) vs. Turbulent (T)
];

// Debug: Log input responses
error_log("Input responses: " . print_r($responses, true));

// Aggregate scores
foreach ($responses as $response) {
    if (!isset($response['dimension']) || !isset($response['value'])) {
        continue; // Skip invalid responses
    }

    $dimension = strtolower($response['dimension']); // Convert dimension to lowercase
    $value = intval($response['value']); // Ensure value is an integer

    if (array_key_exists($dimension, $dimensions)) {
        $dimensions[$dimension] += $value; // Aggregate scores for each dimension
    }
}

// Debug: Log aggregated scores
error_log("Aggregated scores: " . print_r($dimensions, true));

// Calculate personality type
$personalityType = "";
$personalityType .= $dimensions['mind'] >= 0 ? 'E' : 'I';    // Mind: E vs. I
$personalityType .= $dimensions['energy'] >= 0 ? 'N' : 'S';  // Energy: N vs. S
$personalityType .= $dimensions['nature'] >= 0 ? 'F' : 'T';  // Nature: F vs. T
$personalityType .= $dimensions['tactics'] >= 0 ? 'J' : 'P'; // Tactics: J vs. P
$personalityType .= '-';
$personalityType .= $dimensions['identity'] >= 0 ? 'A' : 'T'; // Identity: A vs. T

// Debug: Log calculated personality type
error_log("Calculated Personality Type: $personalityType");

// Save or update MBTI type securely
$stmt = $conn->prepare("INSERT INTO felhasznalok (user_email, mbti_type)
                        VALUES (?, ?)
                        ON DUPLICATE KEY UPDATE mbti_type = ?");
$stmt->bind_param("sss", $email, $personalityType, $personalityType);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Test results saved", "mbti_type" => $personalityType]);
} else {
    error_log("SQL error: " . $stmt->error); // Log SQL errors
    echo json_encode(["success" => false, "message" => "Failed to save test results"]);
}

$stmt->close();
$conn->close();
?>
