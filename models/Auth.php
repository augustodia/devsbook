<?php
    require_once 'dao/UserDAOMySql.php';
    class Auth {
        private $pdo;
        private $base;

        public function __construct(PDO $pdo, $base) {
            $this->pdo = $pdo;
            $this->base = $base;
        }

        public function checkToken() {
            if(!empty($_SESSION['token'])) {
                $token = $_SESSION['token'];

                $userDAO = new UserDAOMySQl($this->pdo);
                $user = $userDAO->findByToken($token);
                if($user) {
                    return $user;
                }
            }
            header("Location:".$this->base."/login.php");
            exit;
        }
    }

?>