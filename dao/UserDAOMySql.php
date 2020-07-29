<?php
require_once 'models/User.php';
require_once 'dao/UserRelationDAOMySql.php';
require_once 'dao/PostDAOMySql.php';

class UserDAOMySql implements UserDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    private function generateUser($array, $full = false) {
        $u = new User();
        $u->id = $array['id'] ?? 0;
        $u->email = $array['email'] ?? '';
        $u->password = $array['password'] ?? '';
        $u->name = $array['name'] ?? '';
        $u->birthDate = $array['birth_date'] ?? '';
        $u->city = $array['city'] ?? '';
        $u->work = $array['work'] ?? '';
        $u->avatar = $array['avatar'] ?? '';
        $u->cover = $array['cover'] ?? '';
        $u->token = $array['token'] ?? '';

        if($full) {
            $urDAOMySql = new UserRelationDAOMySql($this->pdo);
            $postDAOMySql = new PostDAOMySql($this->pdo);

            $u->followers = $urDAOMySql->getFollowers($u->id);
            foreach($u->followers as $key => $follower_id) {
                $newUser = $this->findById($follower_id);
                $u->followers[$key] = $newUser;
            }
            $u->following = $urDAOMySql->getFollowing($u->id);
            foreach($u->following as $key => $following_id) {
                $newUser = $this->findById($following_id);
                $u->following[$key] = $newUser;
            }

            $u->photos = $postDAOMySql->getPhotosFrom($u->id);
        }

        return $u;
        
    }

    public function findByToken($token) {
        if(!empty($token)) {
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);
                return $user;

            }
        }
        return false;
    }

    public function findByEmail($email) {
        if(!empty($email)) {
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);
                return $user;
            }
            return false;
            
        }
        
        
    }

    public function findById($id, $full = false) {
        
        if(!empty($id)) {
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data, $full);
                return $user;
            }
        }
        return false;
    }

    public function findByName($name) {
        $array = [];
        if(!empty($name)) {
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE :name");
            $sql->bindValue(':name', '%'.$name.'%');
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $user) {
                    $array[] = $this->generateUser($user);
                }

            }
        }
        return $array;
    }
    public function update(User $u) {
        $sql = $this->pdo->prepare("UPDATE users SET 
            email = :email,
            password = :password,
            name = :name,
            birth_date = :birthDate,
            city = :city,
            work = :work,
            avatar = :avatar,
            cover = :cover,
            token = :token
            WHERE id = :id");
        
        $sql->bindValue(":email", $u->email);
        $sql->bindValue(":password", $u->password);
        $sql->bindValue(":name", $u->name);
        $sql->bindValue(":birthDate", $u->birthDate);
        $sql->bindValue(":city", $u->city);
        $sql->bindValue(":work", $u->work);
        $sql->bindValue(":avatar", $u->avatar);
        $sql->bindValue(":cover", $u->cover);
        $sql->bindValue(":token", $u->token);
        $sql->bindValue(":id", $u->id);
        $sql->execute();

        return true;
    }

    public function insert(User $u) {
        $sql = $this->pdo->prepare("INSERT INTO users (
            email, password, name, birth_date, token
        ) VALUES (
           :email, :password, :name, :birthDate, :token
        )");
        
        $sql->bindValue(':email', $u->email);
        $sql->bindValue(':password', $u->password);
        $sql->bindValue(':name', $u->name);
        $sql->bindValue(':birthDate', $u->birthDate);
        $sql->bindValue(':token', $u->token);
        $sql->execute();

        return true;
    } 
    
}