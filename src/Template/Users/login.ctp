<?= $this->Html->css('login.css', ['block' => true]) ?>
<?php $this->assign('title', 'Log In')?>
<div class="login-card">
    <?php if ($wrong_password): ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span>Invalid <strong>login</strong> or <strong>password</strong></span>
    </div>
    <?php endif; ?>
    <?= $this->Html->image(
        'avatar_img.png', ['class' => 'profile-img-card']
    );
    ?>
    <p class="profile-name-card"></p>

    <form method="post" class="form-sign-in"><span class="re-auth-email"> </span>
        <input name="login" class="form-control" type="text" required="" placeholder="Login" autofocus="" autocomplete="on"
               id="inputLogin">
        <input name="password" class="form-control" type="password" required="" placeholder="Password" autocomplete="on"
               id="inputPassword">
        <button class="btn btn-primary btn-block btn-lg btn-sign-in" type="submit">Login</button>
    </form>
</div>