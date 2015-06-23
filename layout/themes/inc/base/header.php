<body>
    <div class="container">
        <div class="header">
            <ul class="nav nav-pills pull-right">
                <li <?php MenuActive('index|home|home/*', 'class="active"') ?> ><a href="<?=BaseUrl()?>">Home</a></li>
                <li <?php MenuActive('test', 'class="active"') ?> ><a href="<?= BaseUrl()?>test">Página de Teste</a></li>
                <?php if(\core\security\Auth::IsAuth() === false): ?>
                <li <?php MenuActive('login', 'class="active"') ?> ><a href="<?=BaseUrl()?>login">Login</a></li>
                <?php else: ?>
                <li><a href="<?=BaseUrl()?>logout">Logout</a></li>
                <?php endif; ?>
            </ul>
            <h3 class="text-muted"><b>We Framework</b> | App and Front</h3>
        </div>