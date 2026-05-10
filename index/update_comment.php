<?php
require '../config/database.php';

header('Content-Type: application/json');
ob_end_clean(); 

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, true);

$response = ['status' => 'error', 'message' => 'Invalid request'];

file_put_contents('../index/debug_log.txt', "受信データ: " . print_r($_POST, true) . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updates'])) {
    $pdo->beginTransaction();
    try {
        foreach ($_POST['updates'] as $update) {
            $id = $update['id'] ?? null;
            $comment = $update['comment'] ?? '';

            if ($id !== null && $comment !== null) {
                $stmt = $pdo->prepare("UPDATE `mac-address` SET `comment` = :comment WHERE `number` = :id");
                $stmt->execute([':comment' => $comment, ':id' => $id]);
                file_put_contents('../index/debug_log.txt', "更新成功: ID={$id}, Comment={$comment}\n", FILE_APPEND);
            }
        }
        $pdo->commit();
        $response = ['status' => 'success', 'message' => 'All comments updated'];
    } catch (Exception $e) {
        $pdo->rollBack();
        $response['message'] = 'Database error: ' . $e->getMessage();
        file_put_contents('../index/debug_log.txt', "DBエラー: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}

echo json_encode($response);
exit;
