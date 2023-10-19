<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="text-center mb-4">
    <a href="<?=base_url() ?>" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url().setting('Site.logo')?>" height="45" alt=""></a>
</div>

<h2 class="h3 text-center mb-3">
    <?= lang('Auth.login') ?>
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
<form action="<?= url_to('login') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label"><?= lang('Auth.email') ?></label>
        <input name="email" inputmode="email" id="floatingEmailInput" autocomplete="email" type="email" class="form-control" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>"
            required>
    </div>
    <div class="mb-2">
        <label class="form-label">
            <?= lang('Auth.password') ?>
        </label>
        <div class="input-group input-group-flat">
            <input type="password" id="floatingPasswordInput" class="form-control" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
        </div>
    </div>
    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
    <div class="mb-2">
        <label class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?> />
            <span class="form-check-label"><?= lang('Auth.rememberMe') ?></span>
        </label>
    </div>
    <?php endif; ?>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100"><?= lang('Auth.login') ?></button>
    </div>
</form>
<?php if (setting('Auth.allowMagicLinkLogins')) : ?>
<p class="text-center text-secondary mt-3">
    <?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a>
</p>
<?php endif ?>
<?php if (setting('Auth.allowRegistration')) : ?>
<p class="text-center text-secondary mt-3">
    <?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
</p>
<?php endif ?>
<?= $this->endSection() ?>