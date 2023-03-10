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
        <a href="<?=base_url(route_to('customer.add'))?>" class="btn btn-primary btn-sm">Neuer
            Kunde</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Kundenübersicht</h4>
            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Kontakt</th>
                        <th>Firmenname</th>
                        <th>Ort</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($customers as $index => $customer):?>

                    <tr>
                        <td class="align-middle"><?=$customer->contact_lastname?> <?=$customer->contact_firstname?></td>
                        <td class="align-middle"><?=$customer->company?:'---'?></td>
                        <td class="align-middle"><?=$customer->city?></td>
                        <td class="align-middle">
                            <?php if($customer->status == 1):?>
                            <span class="badge text-bg-success text-white">Aktiv</span>
                            <?php else:?>
                            <span class="badge text-bg-danger text-white">Inaktiv</span>
                            <?php endif;?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?=base_url(route_to('customer.show', $customer->id))?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="<?=base_url(route_to('customer.edit', $customer->id))?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-customer btn btn-link text-danger"
                                    data-wid="<?=$customer->id?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>


            </table>
        </div>
    </div>
</div>





<?= $this->endSection() ?>