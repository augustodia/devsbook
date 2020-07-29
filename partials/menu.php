<aside class="mt-10">
            <nav>
                <a href="<?=$base;?>/index.php">
                    <div class="menu-item <?=$activeMenu=='index'?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/home-run.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Feed
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/perfil.php">
                    <div class="menu-item <?=$activeMenu=='perfil'?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/user.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Meu Perfil
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/amigos.php">
                    <div class="menu-item <?=$activeMenu=='amigos'?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/friends.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Amigos
                        </div>
                        <div class="menu-item-badge">
                            33
                        </div>
                    </div>
                </a>
                <div class="menu-splitter"></div>
                <a href="<?=$base;?>/configuracoes.php">
                    <div class="menu-item <?=$activeMenu=='config'?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/settings.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Configurações
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/logout.php">
                    <div class="menu-item">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/power.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Sair
                        </div>
                    </div>
                </a>
            </nav>
        </aside>