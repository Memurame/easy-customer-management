<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="text-center mb-4">
    <a href="<?=base_url() ?>" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url().setting('Site.logo')?>" height="45" alt=""></a>
</div>
<h2 class="h3 text-center mb-3">
    <?= lang('Auth.register') ?>
</h2>
<?php if (session('error') !== null) : ?>
<div class="alert alert-danger" role="alert"><?= session('error') ?></div>
<?php elseif (session('errors') !== null) : ?>
<div class="alert alert-danger" role="alert">
    <?php if (is_array(session('errors'))) : ?>
    <?php foreach (session('errors') as $error) : ?>
    <?= $error ?>
    <br>
    <?php endforeach ?>
    <?php else : ?>
    <?= session('errors') ?>
    <?php endif ?>
</div>
<?php endif ?>

<?php if (session('message') !== null) : ?>
<div class="alert alert-success" role="alert"><?= session('message') ?></div>
<?php endif ?>
<form action="<?= url_to('register') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label"><?= lang('Auth.email') ?></label>
        <input name="email" inputmode="email" id="floatingEmailInput" autocomplete="email" type="email" class="form-control" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>"
            required>
    </div>
    <div class="mb-3">
        <label class="form-label"><?= lang('Auth.username') ?></label>
        <input class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"
            required>
    </div>
    <div class="mb-3">
        <label class="form-label">
            <?= lang('Auth.password') ?>
        </label>
        <div class="input-group input-group-flat">
            <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
        </div>
    </div>
    <div class="mb-2">
        <label class="form-label">
            <?= lang('Auth.passwordConfirm') ?>
        </label>
        <div class="input-group input-group-flat">
            <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password"
                placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
        </div>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100"><?= lang('Auth.register') ?></button>
    </div>
</form>
<p class="text-center text-secondary mt-3">
    <a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a>
</p>


<?= $this->endSection() ?>