<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false, 
        "message" => "Database connection failed"
    ]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['responses']) || !isset($data['email'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false, 
        "message" => "Invalid data provided"
    ]);
    exit();
}

$responses = $data['responses'];
$email = $data['email'];

$dimensions = [
    "mind" => 0,     
    "energy" => 0,   
    "nature" => 0,   
    "tactics" => 0,  
    "identity" => 0  
];


error_log("Input responses: " . print_r($responses, true));


foreach ($responses as $response) {
    if (!isset($response['dimension']) || !isset($response['value'])) {
        continue;
    }

    $dimension = strtolower($response['dimension']); 
    $value = intval($response['value']); 

    if (array_key_exists($dimension, $dimensions)) {
        $dimensions[$dimension] += $value; 
    }
}


error_log("Aggregated scores: " . print_r($dimensions, true));


$personalityType = "";
$personalityType .= $dimensions['mind'] >= 0 ? 'E' : 'I';    
$personalityType .= $dimensions['energy'] >= 0 ? 'N' : 'S';  
$personalityType .= $dimensions['nature'] >= 0 ? 'F' : 'T';  
$personalityType .= $dimensions['tactics'] >= 0 ? 'J' : 'P'; 
$personalityType .= '-';
$personalityType .= $dimensions['identity'] >= 0 ? 'A' : 'T'; 

error_log("Calculated Personality Type: $personalityType");


$stmt = $conn->prepare("INSERT INTO felhasznalok (user_email, mbti_type)
                        VALUES (?, ?)
                        ON DUPLICATE KEY UPDATE mbti_type = ?");
$stmt->bind_param("sss", $email, $personalityType, $personalityType);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true, 
        "message" => "Test results saved", 
        "mbti_type" => $personalityType
    ]);
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Failed to save test results"
    ]);
}

$stmt->close();
mysqli_close($conn);
?>
