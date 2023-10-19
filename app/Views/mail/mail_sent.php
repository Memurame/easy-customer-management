<?= $this->extend("templates/layout") ?>
<?= $this->section("main") ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Gesendete Mails
                </div>
                <h2 class="page-title">
                    Mail
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">Mails, bei welchen einen Fehler beim versendet auftrat, werden jeweils 3
                    mal versucht neu zu versenden. Danach muss der Fehler manuel analysiert werden und die Mail zum
                    erneuten Versenden freigegeben werden.</div>
                <div class="table-responsive-md">
                    <table class="table table-vcenter card-table" id="table-customer">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Versendet am</th>
                                <th>Empfänger</th>
                                <th>Betreff</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mails as $mail): ?>

                            <tr>
                                <td class="align-middle">
                                    <?= $mail->id ?>
                                </td>
                                <td class="align-middle">
                                    <?= $mail->sent_at
                                        ? date("d.m.Y H:i:s", $mail->sent_at)
                                        : "---" ?>
                                </td>
                                <td class="align-middle">
                                    <?= $mail->receiver ?>
                                </td>
                                <td class="align-middle">
                                    <?= $mail->subject ?>
                                </td>
                                <td class="align-middle">
                                    <?php if ($mail->type == "sent"): ?>
                                    <span class="badge text-bg-success text-white">Versendet</span>
                                    <?php elseif ($mail->type == "error"): ?>
                                    <span class="badge text-bg-danger text-white">Fehler beim Versenden</span>
                                    <?php elseif ($mail->error): ?>
                                    <span class="badge text-bg-warning text-white">Fehler
                                        x<?= $mail->error_retries ?></span>
                                    <?php else: ?>
                                    <span class="badge text-bg-primary text-white">Pendent</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Aktion
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">

                                            <?php if ($mail->type != 'queue'): ?>

                                            <a href="#" class="dropdown-item text-warning action-mailreset" data-id="<?= $mail->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh-alert" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                                    <path d="M12 9l0 3"></path>
                                                    <path d="M12 15l.01 0"></path>
                                                </svg>
                                                Erneut senden
                                            </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url(
                                                route_to(
                                                    "mail.detail",
                                                    $mail->id,
                                                ),
                                            ) ?>" class="dropdown-item text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                                    </path>
                                                </svg>
                                                Anzeigen
                                            </a>
                                            <?php if (
                                                auth()
                                                    ->user()
                                                    ->can("customer.delete")
                                            ): ?>
                                            <button class="text-danger dropdown-item delete-mailsent" data-id="<?= $mail->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                                Löschen
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>


                    </table>
                </div>
            </div>

        </div>
    </div>
</div>







<?= $this->endSection() ?>