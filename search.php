<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDAOMySql.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDAO = new UserDAOMySql($pdo);
$searchTerm = filter_input(INPUT_GET, 's');

if (empty($searchTerm)) {
    header("Location: ".$base);
}
$userList = $userDAO->findByName($searchTerm);

require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            <div class="box search"><h2>Pesquisado por: <?=$searchTerm;?></h2>
                <div class="full-friend-list">
                    <?php foreach($userList as $item): ?>
                        <div class="friend-icon">
                            <a href="<?=$base;?>/perfil.php?id=<?=$item->id;?>">
                                <div class="friend-icon-avatar">
                                    <img src="<?=$base;?>/media/avatars/<?=$item->avatar;?>" />
                                </div>
                                <div class="friend-icon-name">
                                <?=$item->name;?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="column side pl-5">
            <div class="box banners">
                <div class="box-header">
                    <div class="box-header-text">Patrocinios</div>
                    <div class="box-header-buttons">
                        
                    </div>
                </div>
                <div class="box-body">
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/php.jpg" /></a>
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel.jpg" /></a>
                </div>
            </div>
            <div class="box">
                <div class="box-body m-10">
                    Criado por <strong>Luiz Augusto</strong> no curso da <a href="https://www.b7web.com.br" target="_blank">B7Web</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
require 'partials/footer.php';
?>