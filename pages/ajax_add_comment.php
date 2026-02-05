<?php
include '../admin/page/library/db.php';
include '../admin/page/library/comment_lib.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $post_id = $_POST['post_id'] ?? null;
        $parent_id = $_POST['parent_id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if (!$post_id || !$name || !$comment) {
            echo json_encode(['status' => 0, 'message' => 'All fields required']);
            exit;
        }
        $c = new Comment();
        $c->add($post_id, $name, $comment, $parent_id ?: null);
        $comments = $c->getByPost($post_id);
        echo json_encode(['status' => 1, 'comments' => $comments]);
        exit;
    }

    echo json_encode(['status' => 0, 'message' => 'Invalid request']);
} catch (Exception $e) {
    echo json_encode(['status' => 0, 'message' => 'Error: ' . $e->getMessage()]);
}
