<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>

<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bearbeiten</li>
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
                <option value="0">-- Kunde auswählen --</option>
                <?php foreach($customers as $customer): ?>
                <option value="<?=$customer->id ?>" <?= ($website->customer_id == $customer->id) ? 'selected' : '' ?>>
                    <?= $customer->company ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6">
            <label for="order_id" class="form-label">Auftrag</label>
            <select class="form-select" name="order_id" id="order_id">
                <option value="0">-- Auftrag auswählen --</option>
                <?php foreach($orders as $order): ?>
                <option value="<?=$order->id ?>" <?= ($website->order_id == $order->id) ? 'selected' : '' ?>>
                    <?= $order->name ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label for="website_url" class="form-label">Domain <span class="text-danger">*</span></label>
            <input type="text" class="form-control <?php if(session('errors.website_url')) : ?>is-invalid<?php endif ?>"
                id="website_url" name="website_url" value="<?=$website->website_url ?>">
        </div>
        <div class="col-12">
            <label for="website_url" class="form-label">Tags</label>
            <select class="select2-tags form-select" name="tags[]" id="tags" multiple="multiple">
                <?php foreach($taglist as $tag): ?>
                <option value="<?=$tag->id ?>" <?= ($website->hasTag($tag->id) ? 'selected' : '')?>>
                    <?=$tag->name ?></option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="col-md-6">
            <label for="website_installed" class="form-label">Webseite installiert am</label>
            <input type="date" class="form-control" id="website_installed" name="website_installed"
                value="<?=$website->website_installed ?>">
        </div>
        <div class="col-md-6">
            <label for="website_live" class="form-label">Webseite aufgeschalten am</label>
            <input type="date" class="form-control" id="website_live" name="website_live"
                value="<?=$website->website_live ?>">
        </div>
        <div class="col-12">
            <label for="notes" class="form-label">Notizen</label>
            <textarea class="form-control" rows="5" id="notes" name="notes"><?=$website->notes ?></textarea>
        </div>
    </div>
</form>





<?= $this->endSection() ?>