<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url(route_to('tag.index'))?>">Schlagwort</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bearbeiten</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label">Schlagwort <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.name')) : ?>is-invalid<?php endif ?>" id="name"
                        name="name" value="<?=$taglist->name ?>">
                </div>
                <div class="col-md-6">
                    <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.class')) : ?>is-invalid<?php endif ?>" id="class"
                        name="class" value="<?=$taglist->class ?>">
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>