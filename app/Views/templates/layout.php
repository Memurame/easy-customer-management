<!doctype html>
<html lang="de">

<head>
    <meta name="url" href="<?php echo base_url()?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Thomas Hirter vom Berner Bauern Verband">
    <title><?=service('settings')->get('App.siteName')?></title>

    <link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <link rel="icon" type="image/png" href="<?=base_url()?>favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?=base_url()?>favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>apple-touch-icon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">


    <link href="<?=base_url()?>assets/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/ecm.css" rel="stylesheet">
</head>

<body class="app">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <input type="hidden" id="csrf_security" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <div>
        <!-- #Left Sidebar ==================== -->
        <div class="sidebar">
            <div class="sidebar-inner">
                <!-- ### $Sidebar Header ### -->
                <div class="sidebar-logo">
                    <div class="peers ai-c fxw-nw">
                        <div class="peer peer-greed">
                            <a class="sidebar-link td-n" href="<?=base_url()?>">
                                <div class="peers ai-c fxw-nw">
                                    <div class="peer">
                                        <div class="logo">
                                            <img src="<?=base_url()?>assets/logo-ecm.png" alt="">
                                        </div>
                                    </div>
                                    <div class="peer peer-greed">
                                        <h5 class="lh-1 mB-0 logo-text">Easy Customer Management</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="peer">
                            <div class="mobile-toggle sidebar-toggle">
                                <a href="" class="td-n">
                                    <i class="ti-arrow-circle-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ### $Sidebar Menu ### -->
                <ul class="sidebar-menu scrollable pos-r">
                    <li class="nav-item mT-30 <?= (current_page(route_to('home'), true)) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('home'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-house c-blue-500"></i>
                            </span>
                            <span class="title">Übersicht</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('customer.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('customer.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-people-group c-brown-500"></i>
                            </span>
                            <span class="title">Kunden</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('project.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('project.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-regular fa-folder-open c-blue-500"></i>
                            </span>
                            <span class="title">Projekte</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('website.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('website.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-globe c-deep-orange-500"></i>
                            </span>
                            <span class="title">Webseiten</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('invoice.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('invoice.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-file-invoice c-deep-purple-500"></i>
                            </span>
                            <span class="title">Rechnungen</span>
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item <?= (current_page(route_to('admin.settings'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('admin.settings'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-gear c-blue-grey-500"></i>
                            </span>
                            <span class="title">Einstellungen</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('user.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('user.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-user c-blue-grey-500"></i>
                            </span>
                            <span class="title">Benutzer</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('tag.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url(route_to('tag.index'))?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-tag c-blue-grey-500"></i>
                            </span>
                            <span class="title">Tags</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- #Main ============================ -->
        <div class="page-container">
            <!-- ### $Topbar ### -->
            <div class="header navbar">
                <div class="header-container">
                    <ul class="nav-left">
                        <li>
                            <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1"
                                data-bs-toggle="dropdown">
                                <div class="peer mR-10">
                                    <img class="w-2r bdrs-50p" src="<?=base_url()?>assets/avatar.jpg" alt="">
                                </div>
                                <div class="peer">
                                    <span class="fsz-sm c-grey-900"><?= auth()->user()->username ?></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu fsz-sm">
                                <!--<li>
                                    <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-settings mR-10"></i>
                                        <span>Setting</span>
                                    </a>
                                </li>-->
                                <!--<li>
                                    <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-user mR-10"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>-->
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?=base_url(route_to('logout'))?>"
                                        class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-power-off mR-10"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>

            <!-- ### $App Screen Content ### -->
            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    <div class="container-fluid">
                        <?= $this->renderSection('main') ?>
                    </div>

                </div>

            </main>

            <!-- ### $App Screen Footer ### -->
            <footer class="bdT ta-c lh-0 fsz-sm c-grey-600" style="padding: 18px">
                <p class=" m-0">Developed by <a href="https://github.com/Memurame/easy-customer-management"
                        target="_blank" title="Colorlib">Thomas Hirter</a> | Design by <a href="https://colorlib.com"
                        target="_blank" title="Colorlib">Colorlib</a> | Version:
                    <?=config('App')->version?></p>
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>assets/js/main.js"></script>
    <script src="<?=base_url()?>assets/js/ecm.js"></script>

    <?= view('templates/notification.php') ?>



</body>

</html>