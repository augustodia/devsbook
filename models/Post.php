<?php 
class Post {
    public $id;
    public $id_user;
    public $type;
    public $created_at;
    public $body;
}

interface PostDAO {
    public function insert(Post $p);
}   