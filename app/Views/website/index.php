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
        <a href="<?=base_url()?><?=route_to('website.add')?>" class="btn btn-primary btn-sm">Neue
            Webseite</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Webseitenübersicht</h4>
            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Kunde</th>
                        <th>Domain</th>
                        <th>Installiert</th>
                        <th>Tags</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($websites as $id => $website):
                $installed = ($website->website_installed) ? new DateTime($website->website_installed) : null;
                ?>
                    <tr>
                        <td class="align-middle">
                            <?=($website->getCustomerInfo('company') ? '<a href="'.base_url().route_to('customer.show', $website->getCustomerInfo('id')).'">'.$website->getCustomerInfo('company').'</a>' : '---') ?>
                        </td>
                        <td class="align-middle"><?=$website->website_url?></td>
                        <td class="align-middle">
                            <?= ($website->website_installed) ? $installed->format('d.m.Y') : '---'?>
                        </td>
                        <td class="align-middle">
                            <?php foreach($website->getTags() as $tag): ?>
                            <span
                                class="badge <?=($tag['class']) ? $tag['class'] : 'text-bg-secondary'?>"><?=$tag['name']?></span>
                            <?php endforeach; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="https://<?=$website->website_url?>" target="_blank"
                                    class="btn btn-link text-secondary"><i class="fa-solid fa-globe"></i></a>
                                <a href="<?=base_url()?><?=route_to('website.show', $website->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="<?=base_url()?><?=route_to('website.edit', $website->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-website btn btn-link text-danger"
                                    data-wid="<?=$website->id?>"><i class="fa-solid fa-trash"></i></a>
                            </div>

                        </td>
                        <?php endforeach; ?>
                    </tr>

            </table>
        </div>
    </div>
</div>



<?= $this->endSection() ?>