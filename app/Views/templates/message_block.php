<?php if (session()->has('message')) : ?>
    <div class="alert alert-success">
        <?= session('message') ?>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
    <ul class="list-group pb-3">
        <?php foreach (session('errors') as $error) : ?>
            <li class="list-group-item list-group-item-danger"><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>