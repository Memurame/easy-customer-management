<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

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
    <!-- CSS files -->
    <link href="<?= base_url() ?>dist/css/tabler.min.css?1692870487" rel="stylesheet" />
    <link href="<?= base_url() ?>dist/css/tabler-flags.min.css?1692870487" rel="stylesheet" />
    <link href="<?= base_url() ?>dist/css/tabler-payments.min.css?1692870487" rel="stylesheet" />
    <link href="<?= base_url() ?>dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="@sweetalert2/theme-material-ui/material-ui.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ecm.css">
    <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }
    </style>
</head>

<body>
    <input type="hidden" id="csrf_security" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?=base_url() ?>">
                        <img src="<?= base_url() . setting('Site.logo') ?>" width="110" height="32" alt="ECM" class="navbar-brand-image">
                    </a>
                </h1>
            </div>
        </header>
        <div class="page-wrapper">
            <?= $this->renderSection("main") ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>dist/js/tabler.min.js?1692870487" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url() ?>dist/libs/litepicker/dist/litepicker.js?1692870487" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ogrp83qx6bkmtc1n5bjxqkgzaibula4gyfa44goo79nt7yk3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="<?= base_url() ?>assets/js/tabler_custom.js"></script>
    <script src="<?= base_url() ?>assets/js/ecm.js"></script>



    <?= view("templates/notification.php") ?>
</body>

</html>