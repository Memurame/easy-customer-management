<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kunden</li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('invoice.add')?>" class="btn btn-primary btn-sm">Neuer Kunde</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nachname</th>
                <th>Vorname</th>
                <th>Firmenname</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($invoices as $index => $invoice):
            

            ?>
            
            <tr>
                <td><?=$date->format('d.m.Y')?></td>
                <td><?=$website->website_url?></td>
                <td>
                    <?php if($invoice->paid):?>
                        <span class="badge rounded-pill text-bg-success">Ja</span>
                    <?php else:?>
                        <span class="badge rounded-pill text-bg-danger">Nein</span>
                    <?php endif;?>        
                </td>
                <td>
                    <?php if($invoice->renew == 1):?>
                        <span class="badge rounded-pill text-bg-success">Monatlich</span>
                    <?php elseif($invoice->renew == 2):?>
                        <span class="badge rounded-pill text-bg-success">Jährlich (Rechnungsdatum)</span>
                    <?php elseif($invoice->renew == 3):?>
                        <span class="badge rounded-pill text-bg-success">Jährlich (1. Januar)</span>
                    <?php else:?>
                        <span class="badge rounded-pill text-bg-danger">Nein</span>
                    <?php endif;?>        
                </td>
                <td></td>
            </tr>
            <?php endforeach; ?>
        
        </tbody>
            

    </table>
    </div>
</div>



<?= $this->endSection() ?>
