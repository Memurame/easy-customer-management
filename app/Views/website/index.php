<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Webseiten</li>
        </ol>
    </div>

    <div class="">
        <a href="https://wpmonitoring.bernerbauern.ch/wp-admin/admin.php?page=mainwp_tab" class="btn btn-dark btn-sm" target="_blank">zum Monitoring</a>
        <a href="<?=base_url()?><?=route_to('website.add')?>" class="btn btn-primary btn-sm">Neue Webseite</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Firma</th>
                <th>Domain</th>
                <th>Installiert</th>
                <th>Update</th>
                <th>PopularFX</th>
                <th>BEBV Mitglied</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach($websites as $id => $website):
                $invoice = ($website->invoice_date) ? new DateTime($website->invoice_date) : null;
                $paid = ($website->invoice_paid) ? new DateTime($website->invoice_paid) : null;
                $installed = ($website->website_installed) ? new DateTime($website->website_installed) : null;
                ?>
                <tr>
                    <td><?=$website->contact_lastname?> <?=$website->contact_firstname?></td>
                    <td><?=$website->contact_company?></td>
                    <td><?=$website->website_url?></td>
                    <td><?= ($website->website_installed) ? $installed->format('d.m.Y') : '---'?></td>
                    <td>
                        <?php if($website->update_abo != 'Kein Abo'):?>
                            <span class="badge rounded-pill text-bg-success"><?=$website->update_abo?></span>
                        <?php else:?>
                            <span class="badge rounded-pill text-bg-danger"><?=$website->update_abo?></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($website->license_popularfx):?>
                            <span class="badge rounded-pill text-bg-success">Ja</span>
                        <?php else:?>
                            <span class="badge rounded-pill text-bg-danger">Nein</span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($website->bebv_member):?>
                            <span class="badge rounded-pill text-bg-success">Ja</span>
                        <?php else:?>
                            <span class="badge rounded-pill text-bg-danger">Nein</span>
                        <?php endif;?>
                    </td>
                    <td>
                        <a href="https://<?=$website->website_url?>" target="_blank"><i class="fa-solid fa-globe"></i></a>
                        <a href="<?=base_url()?><?=route_to('website.show', $website->id)?>"><i class="fa-solid fa-eye"></i></a>
                        <a href="<?=base_url()?><?=route_to('website.edit', $website->id)?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href=""><i class="fa-solid fa-trash"></i></a>

                    </td>
                    <?php endforeach; ?>
                </tr>

        </table>
    </div>
</div>



<?= $this->endSection() ?>
