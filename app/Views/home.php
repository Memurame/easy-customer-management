<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
    <h1>Verwaltung für die IT-Dienstleistungen</h1>
    <p class="fs-5 col-md-8">Dies ist eine Verwaltung für alle Arten von Dienstleistungen im IT-Bereich.</p>

    <hr class="col-3 col-md-2 mb-5">

    <div class="row g-5">
        <div class="col-md-6">
           
        </div>

        <div class="col-md-6">
            <h2>Arbeitshilfen</h2>
            <p>Hilfreiche Tools für deine Arbeiten</p>
            <ul class="icon-list ps-0">
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('customer.index')?>">Kunden</a></li>
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('order.index')?>">Aufträge</a></li>
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('invoice.index')?>">Rechnungen</a></li>
            </ul>
        </div>
    </div>
<?= $this->endSection() ?>