<?php
include '../admin/page/library/db.php';
include '../admin/page/library/comment_lib.php';
header('Content-Type: application/json');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $commentText = trim($_POST['comment'] ?? '');

        if (!$id || !$commentText) {
            echo json_encode(['status' => 0, 'message' => 'Invalid input']);
            exit;
        }
        $c = new Comment();
        $c->update($id, $commentText);

        $postId = $c->getPostIdByComment($id);
        $comments = $c->getByPost($postId);

        echo json_encode(['status' => 1, 'comments' => $comments]);
        exit;
    }

    echo json_encode(['status' => 0, 'message' => 'Invalid request']);
} catch (Exception $e) {
    echo json_encode(['status' => 0, 'message' => 'Error: ' . $e->getMessage()]);
}
