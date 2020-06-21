<?php 
require 'config.php';
require 'models/Auth.php';
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$birthDate = filter_input(INPUT_POST, 'birthdate');


if($name && $email && $password && $birthDate) {
    $auth = new Auth($pdo, $base);

    $birthDate = explode('/', $birthDate);
    if(count($birthDate) != 3) {
        $_SESSION['flash'] = 'Data inválida!';
        header("Location: ".$base."/signup.php");
        exit;
    }
    $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0];
    if(strtotime($birthDate) === false){
        $_SESSION['flash'] = 'Data de nascimento inválida!';
        header("Location: $base/signup.php");
        exit;
    }

    if($auth->emailExists($email) === false ) {
        $auth->registerUser($name, $email, $password, $birthDate);
        header("Location: ".$base);
        exit;
    } else {
        $_SESSION['flash'] = 'Email já cadastrado.';
        header("Location: ".$base."/signup.php");
        exit;        
    }
}
$_SESSION['flash'] = 'Campos não enviados.';
header("Location: ".$base."/login.php");
exit;

?>
