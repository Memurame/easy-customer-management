<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
    <h1>Diverse Arbeitshilfen</h1>
    <p class="fs-5 col-md-8">Hier findest du verschiedene Tools welche dir deine Arbeiten oder Arbeitsabläufe erleichtern sollen.</p>

    <hr class="col-3 col-md-2 mb-5">

    <div class="row g-5">
        <div class="col-md-6">
            <h2>Unsere Platformen</h2>
            <p>Eine Auflistung von Webseiten welche beim BEBV existieren</p>
            <ul class="icon-list ps-0">
                <li class="d-flex align-items-start mb-1"><a href="https://inventar.bernerbauern.ch" rel="noopener" target="_blank">ICT-Inventar</a></li>
                <li class="d-flex align-items-start mb-1"><a href="https://wiki.bernerbauern.ch" rel="noopener" target="_blank">BEBV Wiki</a></li>
                <li class="d-flex align-items-start mb-1"><a href="https://abacus.bernerbauern.ch/" rel="noopener" target="_blank">ABACUS</a></li>
                <li class="d-flex align-items-start mb-1"><a href="https://zeiterfassung.bernerbauern.ch/" rel="noopener" target="_blank">Projekt-Zeiterfassung</a></li>
                <li class="d-flex align-items-start mb-1"><a href="https://gate.bernerbauern.ch/" rel="noopener" target="_blank">Citrix</a></li>
                <li class="d-flex align-items-start mb-1"><a href="https://owa.bernerbauern.ch/" rel="noopener" target="_blank">Outlook Webmail</a></li>
            </ul>
        </div>

        <div class="col-md-6">
            <h2>Arbeitshilfen</h2>
            <p>Hilfreiche Tools für deine Arbeiten</p>
            <ul class="icon-list ps-0">
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('abacus.export')?>">ABACUS Adressen Export (ZD)</a></li>
                <li class="d-flex align-items-start mb-1"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten Kunden (ICT)</a></li>
            </ul>
        </div>
    </div>
<?= $this->endSection() ?>