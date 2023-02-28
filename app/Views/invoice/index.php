<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rechnungen</li>
        </ol>
    </div>


    <div>
        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceInfo">
            <i class="fa-solid fa-circle-info"></i>
        </button>
        <a href="<?=base_url()?><?=route_to('invoice.add')?>" class="btn btn-primary btn-sm">Neue Rechnung</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Rechnungsübersicht</h4>
            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Rechnungsdatum</th>
                        <th>Bezeichnung</th>
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
                        <td class="align-middle"><?=$date->format('Y.m.d')?></td>
                        <td class="align-middle"><?=$invoice->description?></td>
                        <td class="align-middle">
                            <?= $invoice->amount?: '---';?>
                        </td>
                        <td class="align-middle">
                            <?php if($invoice->renew_interval == 1):?>
                            <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Monatlich
                                (Rechnungsdatum)</span>
                            <?php elseif($invoice->renew_interval == 2):?>
                            <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Monatlich
                                (1. im Monat)</span>
                            <?php elseif($invoice->renew_interval == 3):?>
                            <span class="badge  text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Jährlich
                                (Rechnungsdatum)</span>
                            <?php elseif($invoice->renew_interval == 4):?>
                            <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Jährlich
                                (1. Januar)</span>
                            <?php elseif($invoice->renew_interval == 0):?>
                            <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Einmalig</span>
                            <?php endif;?>

                            <?php if($invoice->paid == 1):?>
                            <span class="badge text-bg-success">Bezahlt</span>
                            <?php elseif($invoice->paid == 2):?>
                            <span class="badge text-bg-warning">Rechnung generieren</span>
                            <?php elseif($invoice->paid == 3):?>
                            <span class="badge text-bg-danger">Überfällig</span>
                            <?php elseif($invoice->paid == 4):?>
                            <span class="badge text-bg-info">Geplannt</span>
                            <?php elseif($invoice->paid == 0):?>
                            <span class="badge text-bg-warning">Offen</span>
                            <?php endif;?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?=base_url()?><?=route_to('invoice.show', $invoice->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="<?=base_url()?><?=route_to('invoice.edit', $invoice->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-invoice btn btn-link text-danger"
                                    data-id="<?=$invoice->id?>"><i class="fa-solid fa-trash"></i></a>
                            </div>

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
                    <p><strong>Monatliche</strong> Rechnungen welche wiederkehrend sind werden automatsich 14 Tage vor
                        dem
                        nächsten
                        Rechnungsdatum generiert und mit <span class="badge text-bg-warning">Rechnung generieren</span>
                        markiert.</p>
                    <p><strong>Jährliche</strong> Rechnungen welche wiederkehrend sind werden automatsich 30 Tage vor
                        dem
                        nächsten
                        Rechnungsdatum (den 1. Januar) generiert und mit <span class="badge text-bg-warning">Rechnung
                            generieren</span>
                        markiert.</p>
                    <h4>Überfällig</h4>
                    <p><strong>Offene</strong> Rechnungen welche die Zahlungsrist von 30 Tagen überschritten haben
                        werden
                        autmatisch von <span class="badge text-bg-warning">Offen</span> zu <span
                            class="badge text-bg-danger">Überfällig</span> geändert.</p>
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


    <?= $this->endSection() ?>