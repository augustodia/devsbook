<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDAOMySql.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'config';
$userDAO = new UserDAOMySql($pdo);

require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            <div class="box config">
                <h2>Configurações</h2>

                <?php if (!empty($_SESSION['flash'])):?>
                <?='<p>'.$_SESSION['flash'].'</p>';?>
                <?php $_SESSION['flash'] = '';?>
                <?php endif;?>
                
                <form method="POST" class="config-form" enctype="multipart/form-data" action="configuracoes_action.php"> 
                
                <label>Avatar: </label>
                <input type="file" name="avatar"/>
                <img src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>" class="mini"/>
                <label>Capa: </label>
                <input type="file" name="cover"/>
                <img src="<?=$base;?>/media/covers/<?=$userInfo->cover;?>" class="mini"/>

                <hr class="bugfix"/>

                <label>
                    Nome Completo: <span>*</span><br/> 
                    <input type="text" name="name" value="<?=$userInfo->name;?>"/>
                </label>
                
                <label>Email: <span>*</span><br/>
                <input type="email" name="email" value="<?=$userInfo->email;?>" />
                </label>
                <label>Cidade<br/>
                <input type="text" name="city" value="<?=$userInfo->city;?>" />
                </label>
                <label>Trabalho:<br/> 
                <input type="text" name="work" value="<?=$userInfo->work;?>" />
                </label>
                

                <hr/>

                <label>Nova senha: <br/>
                <input type="password" name="password" />
                </label>
                <label>Confirmar nova senha:<br/> 
                <input type="password" name="password_confirmation" />
                </label>

                <button class="button config">Salvar</button>
                </form>
            </div>
        </div>
    
    </div>
</section>

<?php 
require 'partials/footer.php';
?>