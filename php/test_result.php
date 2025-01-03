<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();

}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!isset($data['responses'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No responses provided"]);
    exit();
}

$responses = $data['responses'];

foreach ($responses as $questionIndex => $answer) {
    $questionIndex = intval($questionIndex) + 1; // Convert index to question number
    $answer = intval($answer);

    $sql = "INSERT INTO responses (question_id, answer) VALUES ($questionIndex, $answer)";
    if (!mysqli_query($conn, $sql)) {
        echo json_encode(["success" => false, "message" => "Failed to save response for question $questionIndex"]);
        mysqli_close($conn);
        exit();
    }
}

mysqli_close($conn);
echo json_encode(["success" => true, "message" => "Responses saved successfully"]);
?>
