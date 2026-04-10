<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';
$aspiration_id = intval($_POST['aspiration_id']);
$status        = trim($_POST['status']);
$feedback      = trim($_POST['feedback']);

$stmt = $conn->prepare("UPDATE aspirasi SET status = ?, feedback = ? WHERE aspiration_id = ?");
if ($stmt->execute([$status, $feedback, $aspiration_id])) {
    header('Location: ' . BASE_PATH . '/admin?message=updated');
} else {
    die('Error updating aspiration.');
}
