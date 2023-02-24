<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php


?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('customer.index')?>">Kunden</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$customer->contact_lastname?>
                <?=$customer->contact_firstname?></li>
        </ol>
    </div>

    <div class="">

    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="card border-dark mb-3">
            <div class="card-header bg-transparent border-dark d-flex justify-content-between">
                <h4 class="card-title m-0">Kundendaten</h4>
                <a href="<?=base_url()?><?=route_to('customer.edit', $customer->id)?>"
                    class="btn btn-outline-primary btn-sm">Bearbeiten</a>
            </div>
            <div class="card-body text-dark">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php if($customer->status == 1):?>
                        <span class="badge text-bg-success">Aktiv</span>
                        <?php else:?>
                        <span class="badge text-bg-danger">Inaktiv</span>
                        <?php endif;?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kundennummer</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $customer->customernumber?: '---' ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Name, Vorname</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">E-Mail</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <a href="mailto:<?= $customer->contact_mail ?>"><?= $customer->contact_mail ?></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Firma</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $customer->company?:'---' ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Adresse</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $customer->street ?><br>
                        <?= $customer->postcode ?> <?= $customer->city ?>
                    </div>
                </div>
                <div class="row">
                    <textarea class="form-control" rows="8"><?= $customer->notes ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card border-dark">
            <div class="card-header bg-transparent border-dark d-flex justify-content-between">
                <h4 class="card-title m-0">Kommentare</h4>
                <a href="<?=base_url()?><?=route_to('comment.add')?>?customerId=<?=$customer->id?>"
                    class="btn btn-outline-primary btn-sm">Neuer
                    Kommentar</a>
            </div>
            <div class="card-body text-dark">
                <table id="datatable-comments-simple" class="table table-striped" style="width:100%">
                    <tbody>
                        <?php foreach($comments as $index => $comment):
                            if($comment->comment_typ == -1){
                                $typ = 'table-danger';
                            } elseif($comment->comment_typ == 1){
                                $typ = 'table-success';
                            } else {
                                $typ = null;
                            }
                            ?>
                        <tr class="<?=$typ?>">
                            <td>
                                <strong
                                    style="font-size:13px"><?=$comment->created_at->format('d.m.Y - H:i')?></strong><br>
                                <?=$comment->comment?>
                                <hr class="mb-2">
                                <span class="badge text-bg-secondary">Kunde</span>
                                <?=($comment->project_id)? '<span class="badge text-bg-secondary">Projekt</span>': null; ?>
                                <?=($comment->sebsite_id)? '<span class="badge text-bg-secondary">Webseite</span>': null; ?>
                            </td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Neuer Kommentar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>





<?= $this->endSection() ?>