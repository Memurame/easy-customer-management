<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
<?= csrf_field() ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Rechnung
                    </div>
                    <h2 class="page-title">
                        <?= $invoice->description ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="description" class="form-label">Bezeichnung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description"
                                value="<?=$invoice->description ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                            <select id="customer_id" name="customer_id" class="form-select tomselect-search">
                                <option value="0" <?=($invoice->customer_id == 0)? 'selected' : ''?>>-- Bitte auswählen --
                                </option>
                                <?php foreach($customers as $index => $customer): ?>
                                <option value="<?=$customer->id?>" <?=($invoice->customer_id == $customer->id)? 'selected' : ''?>>
                                    <?= $customer->customername ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="project_id" class="form-label">Projekt</label>
                            <select id="project_id" name="project_id" class="form-select" data-selected="<?=$invoice->project_id?>">

                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="website_id" class="form-label">Webseite </label>
                            <select id="website_id" name="website_id" class="form-select" data-selected="<?=$invoice->website_id?>">
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="invoice" class="form-label">Rechnungsdatum <span class="text-danger">*</span></label>
                            <div class="input-icon mb-2">
                                <input class="form-control tabler-datepicker-icon" id="invoice" name="invoice" value="<?=$invoice->invoice ?>">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M11 15h1" />
                                        <path d="M12 15v3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="paid" class="form-label">Bezahlt <span class="text-danger">*</span></label>
                            <select id="paid" name="paid" class="form-select tomselect-default">
                                <option value="0" <?=($invoice->paid == 0)? 'selected' : ''?>>Nein (Rechnung versendet)</option>
                                <option value="1" <?=($invoice->paid == 1)? 'selected' : ''?>>Ja</option>
                                <option value="2" <?=($invoice->paid == 2)? 'selected' : ''?>>Rechnung generieren</option>
                                <option value="3" <?=($invoice->paid == 3)? 'selected' : ''?>>Überfällig</option>
                                <option value="4" <?=($invoice->paid == 4)? 'selected' : ''?>>Geplannt</option>
                                <option value="5" <?=($invoice->paid == 5)? 'selected' : ''?>>Entwurf</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="renew_interval" class="form-label">Intervall <span class="text-danger">*</span></label>
                            <select id="renew_interval" name="renew_interval" class="form-select tomselect-default">
                                <option value="0" <?=($invoice->renew_interval == 0)? 'selected' : ''?>>Einmalig</option>
                                <option value="1" <?=($invoice->renew_interval == 1)? 'selected' : ''?>>Monatlich
                                    (Rechnungsdatum)
                                </option>
                                <option value="2" <?=($invoice->renew_interval == 2)? 'selected' : ''?>>Monatlich (1. im Monat)
                                </option>
                                <option value="3" <?=($invoice->renew_interval == 3)? 'selected' : ''?>>Jährlich
                                    (Rechnungsdatum)
                                </option>
                                <option value="4" <?=($invoice->renew_interval == 4)? 'selected' : ''?>>Jährlich (1. Januar)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="renew" class="form-label">Automatisch erneuern <span class="text-danger">*</span></label>
                            <select id="renew" name="renew" class="form-select tomselect-default">
                                <option value="0" <?=($invoice->renew == 0)? 'selected' : ''?>>Nein</option>
                                <option value="1" <?=($invoice->renew == 1)? 'selected' : ''?>>Ja</option>

                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="contact_name" class="form-label">Kontaktperson</label>
                            <input type="text" class="form-control <?php if(session('errors.contact_name')) : ?>is-invalid<?php endif ?>" id="contact_name" name="contact_name"
                                value="<?=$invoice->contact_name ?>">
                        </div>
                        <div class="col-4">
                            <label for="contact_phone" class="form-label">Telefon direkt</label>
                            <input type="text" class="form-control <?php if(session('errors.contact_phone')) : ?>is-invalid<?php endif ?>" id="contact_phone" name="contact_phone"
                                value="<?=$invoice->contact_phone ?>">
                        </div>
                        <div class="col-4">
                            <label for="contact_mail" class="form-label">Mail direkt</label>
                            <input type="text" class="form-control <?php if(session('errors.contact_mail')) : ?>is-invalid<?php endif ?>" id="contact_mail" name="contact_mail"
                                value="<?=$invoice->contact_mail ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                Solltest du in den Zusatzinfos Hintergrundfarben benutzen, muss dies beim Drucken seperat im Browser eingestellt werden damit die Farben gedruckt werden.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="notes_top" class="form-label">Zusatzinfo Oben</label>
                            <textarea class="form-control" rows="5" name="notes_top" id="notes_top"><?=$invoice->notes_top ?></textarea>
                        </div>
                    </div>
                    <div class=" row mb-3">
                        <div class="col-12">
                            <label for="notes_bottom" class="form-label">Zusatzinfo Unten</label>
                            <textarea class="form-control" rows="5" name="notes_bottom" id="notes_bottom"><?=$invoice->notes_bottom ?></textarea>
                        </div>
                    </div>
                    <div class=" row mb-3">
                        <div class="col-4">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="payment_terms" id="payment_terms" value="1" <?=($invoice->payment_terms == 1)? 'checked' : ''?>>
                                <span class=" form-check-label">Zahlungskondition anzeigen</span>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="notes" class="form-label">Rechnungsinfo (Intern)</label>
                            <textarea class="form-control" rows="5" id="markdown-editor" name="notes"><?=$invoice->notes ?></textarea>
                            <small class="form-hint">Die Rechnungsinfo ist nur Intern und nicht auf der Rechnung sichtbar.</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <a href="<?=base_url(route_to('invoice.show', $invoice->id))?>" class="btn">
                            Abbrechen
                        </a>
                        <button class="btn btn-success d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M14 4l0 4l-6 0l0 -4"></path>
                            </svg>
                            Speichern
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>




<?= $this->endSection() ?>