<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rechnungen</li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('invoice.add')?>" class="btn btn-outline-primary btn-sm">Neue Rechnung</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table id="example" class="table table-striped" style="width:100%">
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
                    <td class="align-middle"><?=$date->format('d.m.Y')?></td>
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
                        <?php else:?>
                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Einmalig</span>
                        <?php endif;?>

                        <?php if($invoice->paid == 1):?>
                        <span class="badge text-bg-success">Bezahlt</span>
                        <?php elseif($invoice->paid == 2):?>
                        <span class="badge text-bg-warning">Pendent</span>
                        <?php elseif($invoice->paid == 3):?>
                        <span class="badge text-bg-danger">Überfällig</span>
                        <?php elseif($invoice->paid == 0):?>
                        <span class="badge text-bg-warning">Offen</span>
                        <?php endif;?>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="<?=base_url()?><?=route_to('invoice.show', $invoice->id)?>"
                                class="btn btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                            <a href="<?=base_url()?><?=route_to('invoice.edit', $invoice->id)?>"
                                class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="#" class="delete-invoice btn btn-outline-danger" data-id="<?=$invoice->id?>"><i
                                    class="fa-solid fa-trash"></i></a>
                        </div>

                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>


        </table>
    </div>
</div>



<?= $this->endSection() ?>