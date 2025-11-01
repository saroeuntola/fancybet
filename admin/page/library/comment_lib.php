<?php
class Comment
{
    public $db;

    public function __construct()
    {
        $this->db = dbConn();
    }
    // Add a comment (or reply)
    public function add($post_id, $name, $comment, $parent_id = null)
    {
        $parent_id = empty($parent_id) ? null : $parent_id;
        $stmt = $this->db->prepare("
        INSERT INTO comments (post_id, parent_id, name, comment)
        VALUES (:post_id, :parent_id, :name, :comment)
    ");
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindValue(':parent_id', $parent_id, $parent_id === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }


    // Delete comment by ID
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Fetch all comments for a post (nested)
    // Comment.php
    public function getByPost($post_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE post_id=:post_id ORDER BY created_at ASC");
        $stmt->execute(['post_id' => $post_id]);
        $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Build nested structure
        $map = [];
        foreach ($allComments as &$c) $map[$c['id']] = $c + ['replies' => []];

        $tree = [];
        foreach ($map as $id => &$c) {
            if ($c['parent_id']) $map[$c['parent_id']]['replies'][] = &$c;
            else $tree[] = &$c;
        }
        return $tree;
    }


    public function update($id, $comment)
    {
        $stmt = $this->db->prepare("UPDATE comments SET comment = :comment WHERE id = :id");
        return $stmt->execute([':comment' => $comment, ':id' => $id]);
    }

    public function getPostIdByComment($id)
    {
        $stmt = $this->db->prepare("SELECT post_id FROM comments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn();
    }


    // Build nested comment tree
    private function buildTree(array $comments, $parentId = null)
    {
        $tree = [];
        foreach ($comments as $comment) {
            if ($comment['parent_id'] == $parentId) {
                $children = $this->buildTree($comments, $comment['id']);
                if ($children) {
                    $comment['replies'] = $children;
                } else {
                    $comment['replies'] = [];
                }
                $tree[] = $comment;
            }
        }
        return $tree;
    }
    
}

?>