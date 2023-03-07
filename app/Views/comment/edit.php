<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item active">Kommentar</li>
                <li class="breadcrumb-item active" aria-current="page">Bearbeiten</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3 mb-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="comment_typ" class="form-label">Art <span class="text-danger">*</span></label>
                    <select id="comment_typ" name="comment_typ" class="form-select">
                        <option value="1" <?=($comment->comment_typ == 1) ? 'selected' : null ?>>Positiv</option>
                        <option value="0" <?=($comment->comment_typ == 0) ? 'selected' : null ?>>Neutral</option>
                        <option value="-1" <?=($comment->comment_typ == -1) ? 'selected' : null ?>>Negativ</option>
                    </select>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                    <select id="customer_id" name="customer_id" class="form-select" disabled>
                        <option value="0" selected>-- Bitte auswählen --</option>
                        <?php foreach($customers as $index => $customer): ?>
                        <option value="<?=$customer->id?>" <?=($comment->customer_id == $customer->id)? 'selected':''?>>
                            <?= $customer->company?: $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="project_id" class="form-label">Projekt</label>
                    <select id="project_id" name="project_id" class="form-select" disabled>
                        <option value="0" selected>-- Keine Angabe --</option>
                        <?php foreach($projects as $index => $project): ?>
                        <option value="<?=$project->id?>" <?=($comment->project_id == $project->id)? 'selected':''?>>
                            <?=$project->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="website_id" class="form-label">Webseite</label>
                    <select id="website_id" name="website_id" class="form-select " disabled>
                        <option value="0" selected>-- Keine Angabe --</option>
                        <?php foreach($websites as $index => $website): ?>
                        <option value="<?=$website->id?>" <?=($comment->website_id == $website->id)? 'selected':''?>>
                            <?=$website->website_url?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="comment" class="form-label">Kommentar</label>
                    <textarea class="form-control" rows="7" id="comment"
                        name="comment"><?=$comment->comment ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>