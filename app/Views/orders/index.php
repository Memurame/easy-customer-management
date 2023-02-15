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
        <a href="<?=base_url()?><?=route_to('customer.add')?>" class="btn btn-primary btn-sm">Neuer Kunde</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table id="example" class="table table-striped" style="width:100%">
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
                <?php foreach($customers as $index => $customer):
            

            ?>

                <tr>
                    <td><?=$customer->contact_lastname?> <?=$customer->contact_firstname?></td>
                    <td><?=$customer->company?></td>
                    <td><?=$customer->city?></td>
                    <td>
                        <?php if($customer->status == 1):?>
                        <span class="badge rounded-pill text-bg-success">Aktiv</span>
                        <?php else:?>
                        <span class="badge rounded-pill text-bg-danger">Inaktiv</span>
                        <?php endif;?>
                    </td>
                    <td class="text-end">
                        <a href="<?=base_url()?><?=route_to('customer.show', $customer->id)?>"><i
                                class="fa-solid fa-eye"></i></a>
                        <a href="<?=base_url()?><?=route_to('customer.edit', $customer->id)?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="delete-customer text-danger" data-wid="<?=$customer->id?>"><i
                                class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>


        </table>
    </div>
</div>



<?= $this->endSection() ?>