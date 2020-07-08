<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDAOMySql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);

if ($body) {
    $postDAO = new PostDAOMySql($pdo);

    $newPost = new Post();
    $newPost->id_user = $userInfo->id;
    $newPost->type = 'text';
    $newPost->created_at = date('Y-m-d H:i:s');
    $newPost->body = $body;

    $postDAO->insert($newPost);
}

header("Location: ".$base."/perfil.php");
exit;
?>