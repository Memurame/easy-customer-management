<?php if (session()->has('message')) : ?>
    <div class="alert alert-important alert-success alert-dismissible" role="alert">
        <div class="d-flex">
            <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
            </div>
            <div>
                <?= session('message') ?>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
        <div class="d-flex">
            <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
            </div>
            <div>
                <?= session('error') ?>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
    <ul class="list-group pb-3">
        <?php foreach (session('errors') as $error) : ?>
            <li class="list-group-item list-group-item-danger"><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>