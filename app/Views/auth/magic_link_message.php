<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<div class="text-center mb-4">
    <a href="<?=base_url() ?>" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url().setting('Site.logo')?>" height="45" alt=""></a>
</div>

<h2 class="h3 text-center mb-3">
    <?= lang('Auth.useMagicLink') ?>
</h2>

<p><b><?= lang('Auth.checkYourEmail') ?></b></p>
<p><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>
<p class="text-center text-secondary mt-3">
    <a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a>
</p>

<?= $this->endSection() ?>