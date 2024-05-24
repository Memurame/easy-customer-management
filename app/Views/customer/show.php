<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Kunde
                    </div>
                    <h2 class="page-title">
                        <?php echo $customer->customername ?>
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?=base_url(route_to('customer.index'))?>" class="btn btn-secondary d-none d-sm-inline-block">
                            Zurück
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kundendaten</h3>
                            <?php if(auth()->user()->can('customer.edit')): ?>
                                <div class="card-actions">
                                    <a href="<?=base_url(route_to('customer.edit', $customer->id))?>" class="btn btn-primary">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                        Bearbeiten
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
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
                            <?php if($customer->addressnumber):?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Adressnummer</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $customer->addressnumber?: '---' ?>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Kundenname</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $customer->customername ?>
                                </div>
                            </div>
                            <?php if($customer->mail):?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">E-Mail</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a href="mailto:<?= $customer->mail ?>"><?= $customer->mail ?></a>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php if($customer->phone):?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telefon</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a href="tel:<?= $customer->phone ?>"><?= $customer->phone ?></a>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Adresse</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= $customer->street ?><br>
                                    <?= $customer->postcode ?> <?= $customer->city ?>
                                </div>
                            </div>
                            <?php if($customer->notes):?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Notiz</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?= $customer->notes ?>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kommentare</h3>
                            <?php if(auth()->user()->can('comment.add')): ?>
                                <div class="card-actions">
                                    <a href="<?=base_url(route_to('comment.add'))?>?customerId=<?=$customer->id?>" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Neu
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table-comments">

                                    <thead>
                                        <th>Datum</th>
                                        <th>Art</th>
                                        <th>Text</th>
                                        <th>Verknüpfung</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($comments as $index => $comment): ?>
                                        <tr>
                                            <td>

                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?=$comment->updated_at->format('Y.m.d - H:i')?></div>
                                                    <?php if($comment->updated_at > $comment->created_at):?>
                                                    <div class="text-secondary small lh-base">(wurde bearbeitet)</div>
                                                     <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($comment->comment_typ == -1): ?>
                                                    <span class="badge bg-red text-red-fg">Negativ</span>
                                                <?php elseif($comment->comment_typ == 0): ?>
                                                    <span class="badge bg-azure text-azure-fg">Neutral</span>
                                                <?php elseif($comment->comment_typ == 1): ?>
                                                    <span class="badge bg-green text-green-fg">Positiv</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?=$comment->comment?></td>
                                            <td>
                                                <?=($comment->customer_id)? '<span class="badge text-bg-secondary">Kunde</span>': null; ?>
                                                <?=($comment->project_id)? '<span class="badge text-bg-secondary">Projekt</span>': null; ?>
                                                <?=($comment->website_id)? '<span class="badge text-bg-secondary">Webseite</span>': null; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if(auth()->user()->can('comment.edit')): ?>
                                                    <a href="<?=base_url(route_to('comment.edit', $comment->id))?>?ref=customer" class="btn btn-icon text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if(auth()->user()->can('comment.delete')): ?>
                                                    <button class="text-danger p-0 btn btn-icon delete-comment"
                                                            data-id="<?=$comment->id?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kontaktpersonen</h3>
                            <?php if(auth()->user()->can('customer.edit')): ?>
                                <div class="card-actions">
                                    <a href="<?=base_url(route_to('contact.add'))?>?customerId=<?=$customer->id?>" class="btn btn-primary">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                        Neu
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                Der Hauptkontakt und Rechnungskontakt können nicht gelöscht werden. Um diese zu löschen, musst du einen anderen Kontakt als solche definieren, danach kannst du den Kontakt löschen. </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table-contacts">

                                    <thead>
                                        <th>Name</th>
                                        <th>Funktion</th>
                                        <th>Telefon</th>
                                        <th>Mail</th>
                                        <th>Adresse</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($customer->contacts as $contact): ?>
                                        <tr >
                                            <td>
                                                <?=$contact->firstname?> <?=$contact->lastname?>
                                                <?php if($contact->isBillingContact()):?>
                                                    <span class="badge bg-blue text-blue-fg">Rechnungskontakt</span>
                                                <?php endif;?>
                                                <?php if($contact->isMainContact()):?>
                                                    <span class="badge bg-azure text-azure-fg">Hauptkontakt</span>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <?php if($contact->typ == "AP"):?>
                                                    Ansprechtsperson
                                                <?php elseif($contact->typ == "GF"):?>
                                                    Geschäftsführer
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <a href="tel:<?=$contact->phone?>"><?=$contact->phone?></a>
                                            </td>
                                            <td>
                                                <a href="mailto:<?=$contact->mail?>"><?=$contact->mail?></a>
                                            </td>
                                            <td>
                                                <?=$contact->street?><br>
                                                <?=$contact->postcode?> <?=$contact->city?>
                                            </td>
                                            <td class="text-end">
                                                <?php if(auth()->user()->can('customer.edit')): ?>
                                                    <a href="<?=base_url(route_to('contact.edit', $contact->id))?>" class="btn btn-icon text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                    </a>
                                                    <?php if($contact->isBillingContact() OR $contact->isMainContact()): ?>
                                                        <button class="text-danger p-0 btn btn-icon delete-customer-contact" data-id="<?=$contact->id?>" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M4 7l16 0"></path>
                                                                <path d="M10 11l0 6"></path>
                                                                <path d="M14 11l0 6"></path>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                            </svg>
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="text-danger p-0 btn btn-icon delete-customer-contact"
                                                                data-id="<?=$contact->id?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M4 7l16 0"></path>
                                                                <path d="M10 11l0 6"></path>
                                                                <path d="M14 11l0 6"></path>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









<?= $this->endSection() ?>