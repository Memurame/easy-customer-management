<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<h1>Übersicht</h1>
<p class="fs-5 col-10">&laquo;Easy Customer Management&raquo; ist eine einfache und simple Kunden und
    Auftragsverwaltung. <br>Gedacht ist ECS für Kleinunternehmen welche sich auf Webseiten und IT-Dienstleistungen
    spezialisieren.
</p>

<hr class="col-3 col-md-2 mb-5">

<div class="row g-5">
    <div class="col-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa-solid fa-people-group fa-10x"></i>
                <a href="<?=base_url()?><?=route_to('customer.index')?>"
                    class="stretched-link text-dark text-decoration-none">
                    <h5 class="card-title">Kundenverwaltung</h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa-solid fa-folder-open fa-10x"></i>
                <a href="<?=base_url()?><?=route_to('order.index')?>"
                    class="stretched-link text-dark text-decoration-none">
                    <h5 class="card-title">Aufträge/Projekte</h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa-brands fa-chrome fa-10x"></i>
                <a href="<?=base_url()?><?=route_to('website.index')?>"
                    class="stretched-link text-dark text-decoration-none">
                    <h5 class="card-title">Webseiten</h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa-solid fa-file-invoice fa-10x"></i>
                <a href="<?=base_url()?><?=route_to('invoice.index')?>"
                    class="stretched-link text-dark text-decoration-none">
                    <h5 class="card-title">Rechnungen</h5>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>