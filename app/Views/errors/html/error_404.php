<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>

    <link href="<?=base_url()?>/assets/style.css" rel="stylesheet">
    <link href="<?=base_url()?>/assets/ecm.css" rel="stylesheet">
</head>

<body class="app">

    <div class="pos-a t-0 l-0 bgc-white w-100 h-100 d-f fxd-r fxw-w ai-c jc-c pos-r p-30">
        <div class="mR-60">
            <img alt="#" src="assets/static/images/404.png">
        </div>

        <div class="d-f jc-c fxd-c">
            <h1 class="mB-30 fw-900 lh-1 c-red-500" style="font-size: 60px;">404</h1>
            <h3 class="mB-10 fsz-lg c-grey-900 tt-c">Oops Page Not Found</h3>
            <p class="mB-30 fsz-def c-grey-700">
                <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
                <?php else : ?>
                <?= lang('Errors.sorryCannotFind') ?>
                <?php endif ?>
            </p>
        </div>
    </div>

    <script src="<?=base_url()?>/assets/main.js"></script>
    <script src="<?=base_url()?>/assets/ecm.js"></script>
</body>

</html>