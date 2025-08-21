<?php
include("config.php");

header('Content-Type: application/json');

$termo = $_GET['termo'] ?? '';

if (strlen($termo) < 2) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, titulo FROM tb_livros WHERE titulo LIKE ? LIMIT 10");
$searchTerm = '%' . $conn->real_escape_string($termo) . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$livros = [];
while ($row = $result->fetch_assoc()) {
    $livros[] = $row;
}

echo json_encode($livros);