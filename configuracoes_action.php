<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDAOMySql.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'config';
$userDAO = new UserDAOMySql($pdo);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
$work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');

if($name && $email) {
    $userInfo->name = $name;
    $userInfo->city = $city;
    $userInfo->work = $work;

    if($userInfo->email != $email) {
        if($userDAO->findByEmail($email) === false)  {
            $userInfo->email = $email;
        } else {
            $_SESSION['flash'] = 'Email já cadastrado.';
            header("Location: ".$base."/configuracoes.php");
            exit;
        }
    }
    
    if(!empty($password)) {
        if($password === $password_confirmation) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userInfo->password = $hash;
        } else {
            $_SESSION['flash'] = 'As senhas não batem.';
            header("Location: ".$base."/configuracoes.php");
            exit;
        }
    }

    if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
        $newAvatar = $_FILES['avatar'];

        if(in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $avatarWidth = 200;
            $avatarHeight = 200;

            list($widthOrigin, $heigthOrigin) = getimagesize($newAvatar['tmp_name']);
            $ratio = $widthOrigin / $heigthOrigin;
            $newWidth = $avatarWidth; 
            $newHeight = $newWidth / $ratio;

            if($newHeight < $avatarHeight) {
                $newHeight = $avatarHeight; 
                $newWidth = $newHeight * $ratio; 
            }
            
            $x = $avatarWidth - $newWidth;
            $y = $avatarHeight - $newHeight;
            $x = $x < 0 ? $x/2 : $x;
            $y = $y < 0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);
            switch($newAvatar['type']) {
                case 'image/jpeg';
                case 'image/jpg';
                    $image = imageCreateFromJpeg($newAvatar['tmp_name']);
                break;
                case 'image/png';
                    $image = imageCreateFromPng($newAvatar['tmp_name']);
                break;
            }

            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0, 
                $newWidth, $newHeight, $widthOrigin, $heigthOrigin
            );
            $avatarName = $userInfo->id.'-'.md5(time().rand(0, 9999)).'.jpg';

            imagejpeg($finalImage, './media/avatars/'.$avatarName, 100);
            $userInfo->avatar = $avatarName;
        }
    }
    //COVER
    if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
        $newCover = $_FILES['cover'];

        if(in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            $coverWidth = 850;
            $coverHeigth = 313;

            list($widthOrigin, $heigthOrigin) = getimagesize($newCover['tmp_name']);
            $ratio = $widthOrigin / $heigthOrigin;
            $newWidth = $coverWidth; 
            $newHeight = $newWidth / $ratio;

            if($newHeight < $coverHeigth) {
                $newHeight = $coverHeigth; 
                $newWidth = $newHeight * $ratio; 
            }
            
            $x = $coverWidth - $newWidth;
            $y = $coverHeigth - $newHeight;
            $x = $x < 0 ? $x/2 : $x;
            $y = $y < 0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($coverWidth, $coverHeigth);
            switch($newCover['type']) {
                case 'image/jpeg';
                case 'image/jpg';
                    $image = imageCreateFromJpeg($newCover['tmp_name']);
                break;
                case 'image/png';
                    $image = imageCreateFromPng($newCover['tmp_name']);
                break;
            }

            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0, 
                $newWidth, $newHeight, $widthOrigin, $heigthOrigin
            );
            $coverName = $userInfo->id.'-'.md5(time().rand(0, 9999)).'.jpg';

            imagejpeg($finalImage, './media/covers/'.$coverName, 100);
            $userInfo->cover = $coverName;
        }
    }

    $userDAO->update($userInfo);
    $_SESSION['flash'] = 'Modificações realizadas com sucesso!';
}

header("Location: ".$base."/configuracoes.php");
exit;