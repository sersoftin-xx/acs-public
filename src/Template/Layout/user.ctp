<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title><?= \Cake\Core\Configure::read('App.AppName') . ' — ' . $this->fetch('title'); ?></title>
    <?= $this->Html->css('bootstrap.min.css'); ?>
    <?= $this->Html->css('font-awesome.min.css'); ?>
    <?= $this->Html->css('bootstrap-addon.css'); ?>
    <?= $this->Html->css('main.css'); ?>
    <?= $this->fetch('css'); ?>

    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '57x57', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-57x57.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '60x60', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-60x60.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '72x72', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-72x72.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '76x76', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-76x76.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '114x114', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-114x114.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '120x120', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-120x120.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '144x144', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-144x144.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '152x152', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-152x152.png']); ?>
    <?= $this->Html->meta(['rel' => 'apple-touch-icon', 'sizes' => '180x180', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'apple-touch-icon-180x180.png']); ?>
    <?= $this->Html->meta(['rel' => 'icon', 'sizes' => '192x192', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'android-chrome-192x192.png']); ?>
    <?= $this->Html->meta(['rel' => 'icon', 'sizes' => '96x96', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'favicon-96x96.png']); ?>
    <?= $this->Html->meta(['rel' => 'icon', 'sizes' => '16x16', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'favicon-16x16.png']); ?>
    <?= $this->Html->meta(['rel' => 'manifest', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'manifest.json']); ?>
    <?= $this->Html->meta(['rel' => 'mask-icon', 'link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'safari-pinned-tab.svg', 'color' => '#5bbad5']); ?>


    <?= $this->Html->meta(['link' => \Cake\Core\Configure::read('App.iconsBaseUrl') . 'favicon.ico']); ?>
    <?= $this->Html->meta('apple-mobile-web-app-title', 'ACS Panel'); ?>
    <?= $this->Html->meta('application-name', 'ACS Panel'); ?>
    <?= $this->Html->meta('msapplication-TileColor', '#00aba9'); ?>
    <?= $this->Html->meta('msapplication-TileImage', \Cake\Core\Configure::read('App.iconsBaseUrl') . 'mstile-144x144.png'); ?>
    <?= $this->Html->meta('msapplication-config', \Cake\Core\Configure::read('App.iconsBaseUrl') . 'browserconfig.xml'); ?>
    <?= $this->Html->meta('theme-color', '#ffffff'); ?>
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand navbar-link">
                <?= $this->Html->image('logo.svg', ['height' => '37', 'class' => 'nav-img']); ?>
            </a>
            <a class="navbar-brand hidden-sm navbar-link" href="#"><?= \Cake\Core\Configure::read('App.AppName') ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navcol">
            <?= $this->cell('Menu', ['users']); ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><strong>Привет, <?= $this->fetch('username') ?>!</strong></a>
                    <ul class="dropdown-menu">
                        <li role="presentation">
                            <?= $this->Html->link(
                                $this->Html->tag('span', '', ['class' => 'fa fa-user']) . ' Зона администратора',
                                ['controller' => 'Logs', 'action' => 'index'],
                                ['escape' => false]
                            ); ?></li>
                        <li role="separator" class="divider"></li>
                        <li role="presentation">
                            <?= $this->Html->link(
                                $this->Html->tag('span', '', ['class' => 'fa fa-sign-out']) . ' Выход',
                                ['controller' => 'Users', 'action' => 'logout'],
                                ['escape' => false]
                            ); ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <?= $this->Flash->render() ?>
</div>
<?= $this->fetch('content') ?>
<?= $this->Html->script('jquery.min.js') ?>
<?= $this->Html->script('bootstrap.min.js') ?>
<?= $this->fetch('script') ?>
</body>

</html>