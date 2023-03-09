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
        Es wurde kein Mail Absender definiert, dieser ist notwendig damit das versenden von Mails funktioniert. <br><a
            href="<?=base_url(route_to('admin.settings'))?>" class="alert-link">Jetzt anpassen</a>
    </div>
</div>
<?php endif; ?>

<h1>Übersicht</h1>
<p class="fs-5 col-10">&laquo;Easy Customer Management&raquo; ist eine einfache und simple Kunden und
    Auftragsverwaltung. <br>Gedacht ist ECS für Kleinunternehmen welche sich auf Webseiten und IT-Dienstleistungen
    spezialisieren.
</p>

<hr class="col-3 col-md-2 mb-5">
<div class="row gap-20">
    <!-- #Toatl Visits ==================== -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Kunden</h6>
            </div>
            <div class="d-flex justify-content-between w-100">
                <span><i class="fa-solid fa-people-group c-green-500 fs-2"></i></span>
                <span
                    class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500"><?=$count['customer']?></span>
            </div>
        </div>
    </div>

    <!-- #Total Page Views ==================== -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Projekte</h6>
            </div>
            <div class="d-flex justify-content-between w-100">
                <span><i class="fa-regular fa-folder-open c-blue-500 fs-2"></i></span>
                <span
                    class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500"><?=$count['project']?></span>
            </div>
        </div>
    </div>

    <!-- #Unique Visitors ==================== -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Webseiten</h6>
            </div>
            <div class="d-flex justify-content-between w-100">
                <span><i class="fa-solid fa-globe c-deep-orange-500 fs-2"></i></span>
                <span
                    class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-orange-50 c-orange-500"><?=$count['website']?></span>
            </div>
        </div>
    </div>

    <!-- #Bounce Rate ==================== -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Rechnungen</h6>
            </div>
            <div class="d-flex justify-content-between w-100">
                <span><i class="fa-solid fa-file-invoice c-deep-purple-500 fs-2"></i></span>
                <span
                    class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500"><?=$count['invoice']?></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>