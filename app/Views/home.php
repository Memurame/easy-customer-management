<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>

<?php if (auth()->user()->inGroup('superadmin', 'admin') AND 
    empty(service('settings')->get('Email.fromEmail')) OR 
    empty(service('settings')->get('Email.fromName'))): ?>
<div class="alert alert-warning d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
        <use xlink:href="#exclamation-triangle-fill" />
    </svg>
    <div>
        Es wurde kein Mail Absender definiert, dieser ist notwendig damit das versenden von Mails funktioniert. <br><a href="<?=base_url(route_to('admin.settings'))?>" class="alert-link">Jetzt
            anpassen</a>
    </div>
</div>
<?php endif; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Übersicht
                </div>
                <h2 class="page-title">
                    Dashboard
                </h2>
            </div>

        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards mb-4">
                <?php if(auth()->user()->can('customer.index')): ?>
                <div class="col-md-6 col-xl-3">
                    <a href="<?= base_url(route_to("customer.index")) ?>" class="card card-sm card-link">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        <?=$count['customer'] ?> Kunde(n)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(auth()->user()->can('project.index')): ?>
                <div class="col-md-6 col-xl-3">
                    <a href="<?= base_url(route_to("project.index")) ?>" class="card card-sm card-link">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-green text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-open" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 19l2.757 -7.351a1 1 0 0 1 .936 -.649h12.307a1 1 0 0 1 .986 1.164l-.996 5.211a2 2 0 0 1 -1.964 1.625h-14.026a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        <?=$count['project'] ?> Projekt(e)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(auth()->user()->can('website.index')): ?>
                <div class="col-md-6 col-xl-3">
                    <a href="<?= base_url(route_to("website.index")) ?>" class="card card-sm card-link">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-red text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-world-www" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4"></path>
                                            <path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4"></path>
                                            <path d="M12.5 3a16.989 16.989 0 0 1 1.828 4"></path>
                                            <path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4"></path>
                                            <path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4"></path>
                                            <path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4"></path>
                                            <path d="M2 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                                            <path d="M17 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                                            <path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        <?=$count['website'] ?> Webseite(n)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php if(auth()->user()->can('invoice.index')): ?>
                <div class="col-md-6 col-xl-3">
                    <a href="<?= base_url(route_to("invoice.index")) ?>" class="card card-sm card-link">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-yellow text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-open" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 19l2.757 -7.351a1 1 0 0 1 .936 -.649h12.307a1 1 0 0 1 .986 1.164l-.996 5.211a2 2 0 0 1 -1.964 1.625h-14.026a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        <?=$count['invoice'] ?> Rechnung(en)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="row row-cards">

                <div class="col-md-6">
                    <div class="card bg-primary text-primary-fg">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-white text-primary">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?=base_url(route_to('feedback'))?>">
                                <h3 class="card-title">Verbesserungen und Ideen</h3>
                                <p>Bei Fragen, Anregungen und Verbesserungen, kontaktiere eine Administrator.</p>
                                <textarea name="feedback" class="form-control mb-2" data-bs-toggle="autosize" placeholder="Feedback schreiben"
                                    style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 60px;"></textarea>
                                <button class="btn btn-outline-light active w-25" type="submit">
                                    Senden
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row row-cards">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Zuletzt aktive Benutzer</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">

                                    <?php foreach($last_active as $lastuser):
                                            $t1 = Time::now();
                                            $diff = $t1->difference($lastuser->last_active);
                                        ?>

                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <?php if($diff->getMinutes() < -15): ?>
                                                <span class="badge bg-red"></span>
                                                <?php else: ?>
                                                <span class="badge bg-green"></span>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col-auto">
                                                <span class="avatar" style="background-image: url(<?=profile($lastuser->id)->avatar?>)"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <?=profile($lastuser->id)->firstname?> <?=profile($lastuser->id)->lastname?>
                                                <?php if($diff->getMinutes() < -15): ?>
                                                <div class="d-block text-secondary text-truncate mt-n1"><?=$lastuser->last_active->toLocalizedString("d.M.Y - HH:mm")?></div>
                                                <?php else: ?>
                                                <div class="d-block text-secondary text-truncate mt-n1">Vor weniger als 15 Minuten</div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>