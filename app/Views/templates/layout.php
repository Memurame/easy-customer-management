<!doctype html>
<html lang="de">

<head>
    <meta name="url" href="<?php echo base_url()?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Thomas Hirter vom Berner Bauern Verband">
    <title><?=service('settings')->get('App.siteName')?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">


    <link href="<?=base_url()?>/assets/style.css" rel="stylesheet">
    <link href="<?=base_url()?>/assets/ecm.css" rel="stylesheet">
</head>

<body class="app">
    <input type="hidden" id="csrf_security" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <div>
        <!-- #Left Sidebar ==================== -->
        <div class="sidebar">
            <div class="sidebar-inner">
                <!-- ### $Sidebar Header ### -->
                <div class="sidebar-logo">
                    <div class="peers ai-c fxw-nw">
                        <div class="peer peer-greed">
                            <a class="sidebar-link td-n" href="index.html">
                                <div class="peers ai-c fxw-nw">
                                    <div class="peer">
                                        <div class="logo">
                                            <img src="<?=base_url()?>/assets/logo-ecm.png" alt="">
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
                    <li class="nav-item mT-30 <?= (current_page(route_to('home'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('home')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-house c-blue-500"></i>
                            </span>
                            <span class="title">Übersicht</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('customer.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('customer.index')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-people-group c-brown-500"></i>
                            </span>
                            <span class="title">Kunden</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('project.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('project.index')?>">
                            <span class="icon-holder">
                                <i class="fa-regular fa-folder-open c-blue-500"></i>
                            </span>
                            <span class="title">Projekte</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('website.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('website.index')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-globe c-deep-orange-500"></i>
                            </span>
                            <span class="title">Webseiten</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (current_page(route_to('invoice.index'))) ? 'actived' : ''?>">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('invoice.index')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-file-invoice c-deep-purple-500"></i>
                            </span>
                            <span class="title">Rechnungen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('invoice.index')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-gear c-blue-grey-500"></i>
                            </span>
                            <span class="title">Einstellungen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="sidebar-link" href="<?=base_url()?><?=route_to('invoice.index')?>">
                            <span class="icon-holder">
                                <i class="fa-solid fa-user c-blue-grey-500"></i>
                            </span>
                            <span class="title">Benutzer</span>
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
            <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                <span>Developed by <a href="https://github.com/Memurame/easy-customer-management" target="_blank"
                        title="Colorlib">Thomas Hirter</a></span> | <span>Design by <a href="https://colorlib.com"
                        target="_blank" title="Colorlib">Colorlib</a></span>
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>/assets/main.js"></script>
    <script src="<?=base_url()?>/assets/ecm.js"></script>


</body>

</html>