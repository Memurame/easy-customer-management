<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.emailActivateTitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="text-center mb-4">
    <a href="<?=base_url() ?>" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url().setting('Site.logo')?>" height="45" alt=""></a>
</div>
<h2 class="h3 text-center mb-3">
    <?= lang('Auth.emailActivateTitle') ?>
</h2>

<?php if (session('error')) : ?>
<div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

<p><?= lang('Auth.emailActivateBody') ?></p>

<form action="<?= site_url('auth/a/verify') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label"><?= lang('Auth.token') ?></label>
        <input type="text" class="form-control" id="floatingTokenInput" name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" value="<?= old('token') ?>"
            required />
    </div>

    <div class="form-footer">
        <button type="submit" class="btn btn-primary w-100"><?= lang('Auth.send') ?></button>
    </div>

</form>

<?= $this->endSection() ?>