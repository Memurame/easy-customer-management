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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.0.0/jsoneditor.min.css" integrity="sha512-8G+Vb2+10BSrSo+wupdzJIylDLpGtEYniQhp0rsbTigPG7Onn2S08Ai/KEGlxN2Ncx9fGqVHtRehMuOjPb9f8g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <div class="navbar-nav flex-row order-md-last">
                    <?php if (new_messages()): ?>
                    <div class="d-flex">
                        <div class="nav-item me-3">
                            <button class="btn btn-outline-danger" data-bs-toggle="offcanvas" href="#messagesOffcanvas" role="button" aria-controls="messagesOffcanvas">
                                Neue Nachricht
                                <span class="badge bg-red text-red-fg ms-2 badge-blink"><?= count(
                                        new_messages(),
                                    ) ?></span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(<?= profile()
                                    ->avatar ?>)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?= profile()->firstname ?></div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <?php if (
                                auth()
                                    ->user()
                                    ->can("message.index")
                            ): ?>
                            <a href="<?= base_url(
                                route_to("message.index"),
                            ) ?>" class="dropdown-item">Nachrichten <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span></a>
                            <?php endif; ?>
                            <?php if (
                                auth()
                                    ->user()
                                    ->can("profile.index")
                            ): ?>
                            <a href="<?= base_url(
                                route_to("profile.index"),
                            ) ?>" class="dropdown-item">Einstellungen</a>
                            <?php endif; ?>
                            <a href="<?= base_url(
                                route_to("logout"),
                            ) ?>" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="navbar-expand-md d-print-none">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item <?= current_page(
                                route_to("home"),
                                true,
                            )
                                ? "active"
                                : "" ?>">
                                <a class="nav-link" href="<?= base_url(
                                    route_to("home"),
                                ) ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Home
                                    </span>
                                </a>
                            </li>
                            <?php if (
                                auth()
                                    ->user()
                                    ->can("customer.index") or
                                auth()
                                    ->user()
                                    ->can("project.index") or
                                auth()
                                    ->user()
                                    ->can("website.index") or
                                auth()
                                    ->user()
                                    ->can("invoice.index")
                            ): ?>
                            <li class="nav-item dropdown <?= current_page(
                                "/ecm",
                            )
                                ? "active"
                                : "" ?>">
                                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M15 15l3.35 3.35" />
                                            <path d="M9 15l-3.35 3.35" />
                                            <path d="M5.65 5.65l3.35 3.35" />
                                            <path d="M18.35 5.65l-3.35 3.35" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        CRM
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("customer.index")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("customer.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("customer.index"),
                                        ) ?>" rel="noopener">
                                        Kunden
                                    </a>
                                    <?php endif; ?>
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("project.index")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("project.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("project.index"),
                                        ) ?>">
                                        Projekte
                                    </a>
                                    <?php endif; ?>
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("website.index")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("website.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("website.index"),
                                        ) ?>" rel="noopener">
                                        Webseiten
                                    </a>
                                    <?php endif; ?>
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("invoice.index")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("invoice.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("invoice.index"),
                                        ) ?>" rel="noopener">
                                        Rechnungen
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if (auth()->user()->can("tool.menu")): ?>
                            <li class="nav-item dropdown <?= current_page(
                                "/tools",
                            )
                                ? "active"
                                : "" ?>">
                                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M15 15l3.35 3.35" />
                                            <path d="M9 15l-3.35 3.35" />
                                            <path d="M5.65 5.65l3.35 3.35" />
                                            <path d="M18.35 5.65l-3.35 3.35" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Tools
                                    </span>
                                </a>

                                <div class="dropdown-menu">
                                    <?php if (auth()->user()->can("estos.index") AND BEBV): ?>
                                        <a class="dropdown-item <?= current_page(route_to("estos.index"))? "active" : "" ?>" href="<?= base_url(route_to("estos.index")) ?>" rel="noopener">
                                            Estos Telefonliste
                                        </a>
                                    <?php endif; ?>
                                    <?php if (auth()->user()->can("testimonial.index")): ?>
                                        <a class="dropdown-item <?= current_page(route_to("testimonial.index")) ? "active" : "" ?>" href="<?= base_url(route_to("testimonial.index")) ?>" rel="noopener">
                                            Testimonial <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (auth()->user()->can("abacus.index") AND BEBV): ?>
                                        <a class="dropdown-item <?= current_page(route_to("abacus.index")) ? "active" : "" ?>" href="<?= base_url(route_to("abacus.index")) ?>" rel="noopener">
                                            Abacus Adressen <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (auth()->user()->can("newsletter.index") AND BEBV): ?>
                                        <a class="dropdown-item <?= current_page(route_to("newsletter.index")) ? "active" : "" ?>" href="<?= base_url(route_to("newsletter.index")) ?>" rel="noopener">
                                            Newsletter <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    <?php endif; ?>
                                </div>


                            </li>
                            <?php endif; ?>
                            <?php if (
                                auth()
                                    ->user()
                                    ->can("mail.index")
                            ): ?>
                            <li class="nav-item dropdown <?= current_page(
                                "/mail",
                            )
                                ? "active"
                                : "" ?>">
                                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                            </path>
                                            <path d="M3 7l9 6l9 -6"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Mail
                                    </span>
                                </a>
                                <?php if (
                                    auth()
                                        ->user()
                                        ->can("mail.add")
                                ): ?>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item <?= current_page(
                                        route_to("mail.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("mail.index"),
                                        ) ?>" rel="noopener">
                                        Mail verfassen <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                    </a>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("mail.sent"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("mail.sent"),
                                        ) ?>" rel="noopener">
                                        Gesendete Mails <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </li>
                            <?php endif; ?>
                            <?php if (
                                auth()
                                    ->user()
                                    ->can("admin.access")
                            ): ?>
                            <li class="nav-item dropdown <?= current_page(
                                "/admin",
                            )
                                ? "active"
                                : "" ?>">
                                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M15 15l3.35 3.35" />
                                            <path d="M9 15l-3.35 3.35" />
                                            <path d="M5.65 5.65l3.35 3.35" />
                                            <path d="M18.35 5.65l-3.35 3.35" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Administration
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("admin.tags")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("tag.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("tag.index"),
                                        ) ?>" rel="noopener">
                                        Tags
                                    </a>
                                    <?php endif; ?>
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("user.index")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("user.index"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("user.index"),
                                        ) ?>">
                                        Benutzer
                                    </a>
                                    <?php endif; ?>
                                    <?php if (
                                        auth()
                                            ->user()
                                            ->can("admin.settings")
                                    ): ?>
                                    <a class="dropdown-item <?= current_page(
                                        route_to("setting.1"),
                                    )
                                        ? "active"
                                        : "" ?>" href="<?= base_url(
                                            route_to("setting.1"),
                                        ) ?>" rel="noopener">
                                        Einstellungen
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <?= $this->renderSection("main") ?>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="messagesOffcanvas" aria-labelledby="messagesOffcanvasLabel">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title" id="offcanvasEndLabel">Neue Nachrichten</h2>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="row row-cards">
                        <div class="col-12">
                            <div class="card">
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <?php foreach (
                                        new_messages()
                                        as $new_message
                                    ): ?>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="badge bg-red"></span></div>
                                            <div class="col-auto">
                                                <a href="<?= base_url(
                                                        route_to(
                                                            "message.index",
                                                        ),
                                                    ) ?>?chat=<?= $new_message->chat_id ?>">
                                                    <span class="avatar" style="background-image: url(<?= profile(
                                                            $new_message->user_id,
                                                        )->avatar ?>)"></span>
                                                </a>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="<?= base_url(
                                                    route_to("message.index"),
                                                ) ?>?chat=<?= $new_message->chat_id ?>" class="text-reset d-block"><?= profile(
                                                        $new_message->user_id,
                                                    )->firstname ?>
                                                    <?= profile(
                                                        $new_message->user_id,
                                                    )->lastname ?></a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    <?= $new_message->message ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Entwickelt von <a href="https://github.com/Memurame/easy-customer-management" target="_blank">Thomas
                                        Hirter</a> | Design von <a href="https://tabler.io/" target="_blank">Tabler</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://github.com/Memurame/easy-customer-management/releases" class="link-secondary" rel="noopener">
                                        Versionen
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>dist/js/tabler.min.js?1692870487" defer></script>
    <script src="<?= base_url() ?>dist/libs/fslightbox/index.js?1692870487" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url() ?>dist/libs/litepicker/dist/litepicker.js?1692870487" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ogrp83qx6bkmtc1n5bjxqkgzaibula4gyfa44goo79nt7yk3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/10.0.0/jsoneditor.min.js" integrity="sha512-vi9Akg8ycb3xXYCKlTgF2aRh9qU4m8za8Y9v+cm4lcg4Cm8koF5NDQwZ0QxF4+AFo3wTvTJFo56dKTeMGhMvzw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>assets/js/tabler_custom.js"></script>
    <script src="<?= base_url() ?>assets/js/ecm.js"></script>


    <script>
    $(document).ready(function() {
        <?php if (isset($tomselectProject)): ?>

        let tomselectProject = new TomSelect($('#project_id'), {
            valueField: 'id',
            labelField: 'name',
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            controlInput: '<input>',
            load: function(query, callback) {

                var url = rootUrl + '/api/0/customer/' + query + '/projects';

                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        callback(json);
                    });

            },
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.name) + '</div>';
                    }
                    return '<div>' + escape(data.name) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.name) + '</div>';
                    }
                    return '<div>' + escape(data.name) + '</div>';
                },
            }
        })
        <?php endif; ?>
        <?php if (isset($tomselectWebsite)): ?>
        let tomselectWebsite = new TomSelect($('#website_id'), {
            valueField: 'id',
            labelField: 'name',
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            controlInput: '<input>',
            load: function(query, callback) {

                var url = rootUrl + '/api/0/customer/' + query + '/websites';

                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        callback(json);
                    });

            },
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.name) + '</div>';
                    }
                    return '<div>' + escape(data.url) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data
                            .customProperties + '</span>' + escape(data.name) + '</div>';
                    }
                    return '<div>' + escape(data.url) + '</div>';
                },
            }
        })
        <?php endif; ?>
        $('#customer_id').bind('change', function() {
            var selected = $(this).children("option:selected").val()

            <?php if (isset($tomselectProject)): ?>
            var selectProject = $('#project_id').data('selected')
            tomselectProject.clear()
            tomselectProject.clearOptions()
            tomselectProject.load(selected)
            tomselectProject.setValue(selectProject)
            <?php endif; ?>
            <?php if (isset($tomselectWebsite)): ?>
            var selectWebsite = $('#website_id').data('selected')
            tomselectWebsite.clear()
            tomselectWebsite.clearOptions()
            tomselectWebsite.load(selected)
            tomselectWebsite.setValue(selectWebsite)
            <?php endif; ?>
        });

        $('#customer_id').trigger('change');

    });
    </script>





    <?= view("templates/notification.php") ?>
</body>

</html>