<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Thomas Hirter vom Berner Bauern Verband">
    <title>Error 404 - <?=service('settings')->get('App.siteName')?></title>

    <link rel="icon" href="<?=base_url()?>assets/images/favicon-bebv.png">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/images/favicon-bebv.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/images/favicon-bebv.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>assets/images/favicon-bebv.png">
    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
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
<body  class=" border-top-wide border-primary d-flex flex-column">
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="empty">
            <div class="empty-header">404</div>
            <p class="empty-title">Ups... Sie haben gerade eine Fehlerseite gefundene</p>
            <p class="empty-subtitle text-secondary">
                Es tut uns leid, aber die von Ihnen gesuchte Seite wurde nicht gefunden
            </p>
            <div class="empty-action mb-6">
                <a href="<?=base_url()?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    Zurück zum Dashboard
                </a>
            </div>
            <div class="text-center mb-4">
                <a href="https://bernerbauern.ch" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url()?>assets/images/BEBV_logo_quer_100.png" height="36" alt=""></a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>
</html>