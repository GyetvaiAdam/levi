<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

$sql = "SELECT `question_text`, `dimension` FROM `kerdesek`";
$result = mysqli_query($conn, $sql);

$questions = [];
$dimensions = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row['question_text'];
        $dimensions[] = $row['dimension'];
    }
    echo json_encode([
        'questions' => $questions, 
        'dimensions' => $dimensions
    ]);
} else {
    echo json_encode([
        'questions' => [], 
        'dimensions' => []
    ]);
}

mysqli_close($conn);
?>
