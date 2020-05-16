<?php 
class user {
    public $id;
    public $email;
    public $password;
    public $name;
    public $birthDate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
}

interface UserDAO {
    public function findByToken($token);
}