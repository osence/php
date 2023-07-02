<?php
// Генерируем очки
$score = rand(1, 100);

// Формируем ответ в JSON формате
$response = array(
    "success" => true,
    "score" => $score
);

// Отправляем ответ
header('Content-Type: application/json');
echo json_encode($response);
?>