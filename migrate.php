<?php
include './admin/page/library/db.php';

try {
    $conn = dbConn(); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $migrations = [

        "CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    parent_id INT DEFAULT NULL,
    name VARCHAR(150) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    ];

    foreach ($migrations as $sql) {
        $conn->exec($sql); 
    }

    $roleCheck = $conn->query("SELECT COUNT(*) FROM roles")->fetchColumn();
    if ($roleCheck == 0) {
        $conn->exec("INSERT INTO roles (name) VALUES ('admin'), ('user')");
        echo "✅ Roles seeded.\n";
    }
    echo "✅ Migration completed successfully.\n";

} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
