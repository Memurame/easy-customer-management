<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>

    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$website->contact_lastname?> <?=$website->contact_firstname?></li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary btn-sm">Bearbeiten</button>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-6">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Name, Vorname</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $website->contact_lastname . ' ' . $website->contact_firstname ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Firma</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $website->contact_company ?>
                </div>
            </div>
        </div>
        <div class="col-6">
            
        </div>
    </div>





<?= $this->endSection() ?>
