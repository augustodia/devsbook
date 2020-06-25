<?php 
require 'config.php';
require 'models/Auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'index';

require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            <?php require 'partials/feed-editor.php'; ?>
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