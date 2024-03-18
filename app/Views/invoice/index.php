<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    CRM
                </div>
                <h2 class="page-title">
                    Rechnungen
                </h2>
            </div>
            <!-- Page title actions -->
            <?php if(auth()->user()->can('invoice.add')): ?>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <?php if(auth()->user()->can('invoice.template')): ?>
                    <a href="<?=base_url(route_to('invoice.show', setting('App.invoiceTemplateId')))?>" class="btn btn-primary d-none d-sm-inline-block">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M13 5h8"></path>
                            <path d="M13 9h5"></path>
                            <path d="M13 15h8"></path>
                            <path d="M13 19h5"></path>
                            <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                            <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                        </svg>
                        Vorlagen
                    </a>
                    <?php endif; ?>
                    <a href="<?=base_url(route_to('invoice.add'))?>" class="btn btn-primary d-none d-sm-inline-block">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Neue Rechnung
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row align-items-center mb-4">
                    <strong class="me-2">Filter:</strong>
                    <select name="filter-invoice" id="filter-invoice" class="form-select me-2" style="width:250px;">
                        <option value="all" <?=($filter == 'all') ? 'selected' : ''?>>Alle</option>
                        <option value="future" <?=($filter == 'future') ? 'selected' : ''?>>Alle (ohne bereits bezahlte)</option>
                        <option value="open" <?=($filter == 'open') ? 'selected' : ''?>>Offene & Geplante</option>
                        <option value="draft" <?=($filter == 'draft') ? 'selected' : ''?>>Entwürfe</option>
                        <option value="overdue" <?=($filter == 'overdue') ? 'selected' : ''?>>Überällige</option>
                        <option value="pending" <?=($filter == 'pending') ? 'selected' : ''?>>Pendent</option>
                    </select>

                </div>
                <div class="table-responsive-md">
                    <table class="table table-vcenter card-table" id="table-invoice">
                        <thead>
                            <tr>
                                <th>Rechnungsdatum</th>
                                <th>Nr.</th>
                                <th>Bezeichnung</th>
                                <th>Kunde</th>
                                <th>Betrag</th>
                                <th>Tags</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoices as $index => $invoice):
                        $date = ($invoice->invoice) ? new DateTime($invoice->invoice) : null;

                        ?>

                            <tr>
                                <td class="align-middle"><?=$date->format('Y-m-d')?></td>
                                <td class="align-middle">RE-<?=str_pad($invoice->id,5,0,STR_PAD_LEFT)?></td>
                                <td class="align-middle">
                                    <?php if(auth()->user()->can('invoice.show')): ?>
                                    <a href="<?=base_url(route_to('invoice.show', $invoice->id))?>">
                                        <?=$invoice->description?>
                                    </a>
                                    <?php else: ?>
                                    <?=$invoice->description?>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <?php if(auth()->user()->can('customer.show')): ?>
                                    <a href="<?=base_url(route_to('customer.show', $invoice->getCustomerInfo('id')))?>"><?=$invoice->getCustomerInfo('customername')?></a>
                                    <?php else: ?>
                                    <?=$invoice->getCustomerInfo('customername')?>
                                    <?php endif; ?>

                                </td>
                                <td class="align-middle">
                                    CHF <?php echo $invoice->getTotal() ?>
                                </td>
                                <td class="align-middle">
                                    <?php if($invoice->renew_interval == 1):?>
                                    <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>" style="margin: 2px 0">Monatlich
                                        (Rechnungsdatum)</span>
                                    <?php elseif($invoice->renew_interval == 2):?>
                                    <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>" style="margin: 2px 0">Monatlich
                                        (1. im Monat)</span>
                                    <?php elseif($invoice->renew_interval == 3):?>
                                    <span class="badge  text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>" style="margin: 2px 0">Jährlich
                                        (Rechnungsdatum)</span>
                                    <?php elseif($invoice->renew_interval == 4):?>
                                    <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>" style="margin: 2px 0">Jährlich
                                        (1. Januar)</span>
                                    <?php elseif($invoice->renew_interval == 0):?>
                                    <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>" style="margin: 2px 0">Einmalig</span>
                                    <?php endif;?>

                                    <?php if($invoice->paid == 1):?>
                                    <span class="badge text-bg-success" style="margin: 2px 0">Bezahlt</span>
                                    <?php elseif($invoice->paid == 2):?>
                                    <span class="badge text-bg-warning" style="margin: 2px 0">Rechnung generieren</span>
                                    <?php elseif($invoice->paid == 3):?>
                                    <span class="badge text-bg-danger" style="margin: 2px 0">Überfällig</span>
                                    <?php elseif($invoice->paid == 4):?>
                                    <span class="badge text-bg-info" style="margin: 2px 0">Geplant</span>
                                    <?php elseif($invoice->paid == 0):?>
                                    <span class="badge text-bg-warning" style="margin: 2px 0">Offen</span>
                                    <?php elseif($invoice->paid == 5):?>
                                    <span class="badge text-bg-dark" style="margin: 2px 0">Entwurf</span>
                                    <?php endif;?>
                                </td>
                                <td class="text-end">
                                    <?php if(auth()->user()->can('invoice.show') OR
                                            auth()->user()->can('invoice.edit') OR
                                            auth()->user()->can('invoice.delete')): ?>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Aktion
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <?php if(auth()->user()->can('invoice.show')): ?>
                                            <a href="<?=base_url(route_to('invoice.show', $invoice->id))?>" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                Detail
                                            </a>
                                            <?php endif;?>
                                            <?php if(auth()->user()->can('invoice.edit')): ?>
                                            <a href="<?=base_url(route_to('invoice.edit', $invoice->id))?>" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                    <path d="M16 5l3 3"></path>
                                                </svg>
                                                Bearbeiten
                                            </a>
                                            <?php endif;?>
                                            <?php if(auth()->user()->can('invoice.delete')): ?>
                                            <button class="text-danger dropdown-item delete-invoice" data-id="<?=$invoice->id?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                                Löschen
                                            </button>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>


                    </table>
                </div>
            </div>
            <div class="modal fade" id="invoiceInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Info</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4>Wiederkehrende Rechnungen</h4>
                            <p><strong>Monatliche</strong> Rechnungen welche wiederkehrend sind, werden automatsich 14 Tage vor
                                dem
                                nächsten
                                Rechnungsdatum generiert und mit <span class="badge text-bg-warning">Rechnung generieren</span>
                                markiert.</p>
                            <p><strong>Jährliche</strong> Rechnungen welche wiederkehrend sind, werden automatsich <?=service('settings')->get('Company.payment_deadline')?> Tage vor
                                dem
                                nächsten
                                Rechnungsdatum (den 1. Januar) generiert und mit <span class="badge text-bg-warning">Rechnung
                                    generieren</span>
                                markiert.</p>
                            <h4>Überfällig</h4>
                            <p><strong>Offene</strong> Rechnungen welche die Zahlungsrist von <?=service('settings')->get('Company.payment_deadline')?> Tagen überschritten haben
                                werden
                                autmatisch von <span class="badge text-bg-warning">Offen</span> zu <span class="badge text-bg-danger">Überfällig</span> geändert.</p>
                            <h4>Geplannte Rechnungen</h4>
                            <p><strong>Geplannt</strong> sind Rechnungen welche z.B erst in einem Jahr oder paar Monaten fällig
                                sind. Diese können als Geplannte Rechnungen erfast werden.<br> 14 Tage vor dem Rechnungsdatum
                                wird
                                der Status automatisch zu <span class="badge text-bg-warning">Rechnung geneieren</span>
                                geändert.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>