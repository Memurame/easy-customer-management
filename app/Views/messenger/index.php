<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Nachrichten
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-4 border-end">
                        <div class="card-body p-0 scrollable" style="max-height: 35rem">
                            <div class="card-header d-block">
                                Neuer Chat starten:
                                <div class="input-icon">
                                    <span class="input-icon-addon"> <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                    </span>
                                    <select class="form-select tomselect-search" name="receiver-select" id="receiver-select">

                                        <?php if($receiverlist): ?>
                                            <option value="0">-- Empfänger auswählen --</option>
                                            <?php foreach($receiverlist as $key => $val): ?>
                                                <option value="<?=$key?>" data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-image: url(<?=profile($key)->avatar ?>)&quot;&gt;&lt;/span&gt;"><?=$val?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="0">Keine verfügbaren Emfänger</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="nav flex-column nav-pills">
                                <?php foreach($chats as $chat): ?>
                                    <a href="<?=base_url(route_to('message.index') .'?chat=' .  $chat->id) ?>" class="nav-link text-start mw-100 p-3 <?= ($chat->id == $currentChat) ? 'active' : '' ?>">
                                        <div class="row align-items-center flex-fill">
                                            <div class="col-auto"><span class="avatar" style="background-image: url(<?= profile($chat->getOtherUser())->avatar?>)"></span>
                                            </div>
                                            <div class="col text-body">
                                                <div><?=profile($chat->getOtherUser())->firstname ?> <?=profile($chat->getOtherUser())->lastname ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 col-xl-8 d-flex flex-column">

                        <?php if($messages): ?>
                            <div class="card-header">
                                <div class="card-actions">
                                    <button class="btn btn-sm btn-danger delete-chat" data-id="<?=$currentChat?>">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                        Chat löschen
                                    </button>
                                </div>
                            </div>
                            <div class="card-body scrollable" style="height: 35rem">
                                <div class="chat">
                                    <div class="chat-bubbles">
                                        <?php foreach($messages as $message):?>
                                            <?php if($message->user_id == user_id()):?>
                                                <div class="chat-item">
                                                    <div class="row align-items-end justify-content-end">
                                                        <div class="col col-lg-6">
                                                            <div class="chat-bubble chat-bubble-me">
                                                                <div class="chat-bubble-title">
                                                                    <div class="row">
                                                                        <div class="col chat-bubble-author">Du</div>
                                                                        <div class="col-auto chat-bubble-date">
                                                                            <?=$message->created_at->toLocalizedString("d.M.Y - H:m")?>
                                                                            <?php if($message->is_read): ?>
                                                                                <span class="text-green"
                                                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                                                      data-bs-title="Nachricht wurde geöffnet und gelesen">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                                                        <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032"></path>
                                                                                        <path d="M15 19l2 2l4 -4"></path>
                                                                                    </svg>
                                                                                </span>
                                                                            <?php else: ?>
                                                                                <span class="text-red"
                                                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                                                      data-bs-title="Nachricht vom Empfänger noch nicht gelesen">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                       <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                                                       <path d="M13.048 17.942a9.298 9.298 0 0 1 -1.048 .058c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a17.986 17.986 0 0 1 -1.362 1.975"></path>
                                                                                       <path d="M22 22l-5 -5"></path>
                                                                                       <path d="M17 22l5 -5"></path>
                                                                                    </svg>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-bubble-body">
                                                                    <p><?=$message->message?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto"><span class="avatar" style="background-image: url(<?= profile()->avatar ?>)"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else:?>
                                                <div class="chat-item">
                                                    <div class="row align-items-end">
                                                        <div class="col-auto"><span class="avatar" style="background-image: url(<?= profile($message->user_id)->avatar?>)"></span>
                                                        </div>
                                                        <div class="col col-lg-6">
                                                            <div class="chat-bubble">
                                                                <div class="chat-bubble-title">
                                                                    <div class="row">
                                                                        <div class="col chat-bubble-author">
                                                                            <?= profile($message->user_id)->firstname ?> <?= profile($message->user_id)->lastname ?>
                                                                        </div>
                                                                        <div class="col-auto chat-bubble-date">
                                                                            <?=$message->created_at->toLocalizedString("d.M.Y - H:m")?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-bubble-body">
                                                                    <p><?=$message->message?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <form method="post">
                                <?= csrf_field() ?>
                                    <div class="input-group mb-2">
                                        <textarea name="message-text" class="form-control" data-bs-toggle="autosize" placeholder="Nachricht eingeben..."></textarea>
                                        <input type="hidden" name="receiver-hidden" value="<?=$receiver?>">
                                        <button class="btn" type="submit">Senden</button>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="card-body scrollable" style="height: 35rem">
                                <div class="text-center pt-5">
                                    <h3>Wähle einen Chat aus um die Nachrichten anzuzeigen.</h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-opened" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 9l9 6l9 -6l-9 -6l-9 6"></path>
                                        <path d="M21 9v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10"></path>
                                        <path d="M3 19l6 -6"></path>
                                        <path d="M15 13l6 6"></path>
                                    </svg>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>


    <?= $this->endSection() ?>