<!doctype html>
<html lang="de">

<head>
    <meta name="url" href="<?php echo base_url(); ?>">
    <meta name="currentUrl" href="<?php echo current_url(); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Thomas Hirter vom Berner Bauern Verband">
    <title><?= service("settings")->get("Site.title") ?></title>

    <link rel="icon" href="<?=base_url() . setting('Site.logo')?>">
    <link rel="icon" type="image/png" href="<?=base_url() . setting('Site.logo')?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?=base_url() . setting('Site.logo')?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url() . setting('Site.logo')?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/testimonial.css">
</head>

<body>
    <div class="page">
        <?= $this->renderSection("main") ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>