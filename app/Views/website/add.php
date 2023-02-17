<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
                <li class="breadcrumb-item active" aria-current="page">Neu</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3">
        <div class="col-6">
            <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
            <select class="form-select" name="customer_id" id="customer_id">
                <option value"0" selected>-- Kunde auswählen --</option>
                <?php foreach($customers as $customer): ?>
                <option value="<?=$customer->id ?>"><?= $customer->company ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6">
            <label for="order_id" class="form-label">Auftrag</label>
            <select class="form-select" name="order_id" id="order_id">
                <option value"0" selected>-- Auftrag auswählen --</option>
                <?php foreach($orders as $order): ?>
                <option value="<?=$order->id ?>"><?= $order->name ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label for="website_url" class="form-label">Domain <span class="text-danger">*</span></label>
            <input type="text" class="form-control <?php if(session('errors.website_url')) : ?>is-invalid<?php endif ?>"
                id="website_url" name="website_url" value="<?=old('website_url') ?>">
        </div>
        <div class="col-12">
            <label for="website_url" class="form-label">Tags</label>
            <select class="select2-tags form-select" name="tags[]" id="tags" multiple="multiple">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
            </select>
            <small id="tagsHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="col-md-6">
            <label for="website_installed" class="form-label">Webseite installiert am</label>
            <input type="date" class="form-control" id="website_installed" name="website_installed"
                value="<?=old('website_installed') ?>">
        </div>
        <div class="col-md-6">
            <label for="website_live" class="form-label">Webseite aufgeschalten am</label>
            <input type="date" class="form-control" id="website_live" name="website_golive"
                value="<?=old('website_live') ?>">
        </div>
        <div class="col-12">
            <label for="notes" class="form-label">Notizen</label>
            <textarea class="form-control" rows="5" id="notes" name="notes"><?=old('notes') ?></textarea>
        </div>
    </div>
</form>




<?= $this->endSection() ?>