<?= $this->Html->css('login.css', ['block' => true]) ?>
<?php $this->assign('title', 'Вход')?>
<div class="login-card">
    <?php if ($wrong_password): ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span>Неверный <strong>логин</strong> или <strong>пароль.</strong></span>
    </div>
    <?php endif; ?>
    <?= $this->Html->image(
        'avatar_img.png', ['class' => 'profile-img-card']
    );
    ?>
    <p class="profile-name-card"></p>

    <form method="post" class="form-sign-in"><span class="re-auth-email"> </span>
        <input name="login" class="form-control" type="text" required="" placeholder="Логин" autofocus="" autocomplete="on"
               id="inputLogin">
        <input name="password" class="form-control" type="password" required="" placeholder="Пароль" autocomplete="on"
               id="inputPassword">
        <button class="btn btn-primary btn-block btn-lg btn-sign-in" type="submit">Вход</button>
    </form>
</div>