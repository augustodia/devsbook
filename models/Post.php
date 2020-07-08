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
    public function getUserFeed($id);
    public function getHomeFeed($id);
    public function getPhotosFrom($id);
}   