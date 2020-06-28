<?php
require_once 'models/UserRelation.php'; 
class UserRelationDAOMySql implements UserRelationDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    public function insert(UserRelation $ur) {

    }

    public function getRelationsFrom($id) {
        $users = [$id];

        $sql = $this->pdo->prepare("SELECT user_to FROM user_relations WHERE user_from = :user_from");
        $sql->bindValue(':user_from', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $users[] = $item['user_to'];
            }
        }
        return $users;
    }
}