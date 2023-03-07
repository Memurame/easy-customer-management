<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Schlagworte</li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('tag.add')?>" class="btn btn-primary btn-sm">Neues Schlagwort</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Schlagworte</h4>
            <table class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Schlagwort</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($taglist as $index => $tag):
            

            ?>

                    <tr>
                        <td class="align-middle"><?=$tag->name?></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?=base_url()?><?=route_to('tag.edit', $tag->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-tag btn btn-linkr text-danger" data-id="<?=$tag->id?>"><i
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