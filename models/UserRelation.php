<?php 
class UserRelation {
    public $id;
    public $user_from;
    public $user_to;
    
}

interface UserRelationDAO {
    public function insert(UserRelation $ur);
    public function getRelationsFrom($id);
}   