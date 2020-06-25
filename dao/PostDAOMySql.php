<?php
require_once 'models/Post.php';

class PostDAOMySql implements PostDAO {
    private $pdo;
    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    public function insert(Post $p) {
        $sql = $this->pdo->prepare("INSERT INTO posts (
            id_user, type, created_at, body
        ) VALUES (
            :id_user, :type, :created_at, :body
        )");

        $sql->bindValue(':id_user', $p->id_user);
        $sql->bindValue(':type', $p->type);
        $sql->bindValue(':created_at', $p->created_at);
        $sql->bindValue(':body', $p->body);
        $sql->execute();
    }
}


?>