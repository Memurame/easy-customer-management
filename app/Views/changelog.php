<?= $this->extend("templates/layout") ?>
<?= $this->section("main") ?>

<?php if (
    auth()
        ->user()
        ->inGroup("superadmin", "admin") and
        empty(service("settings")->get("Email.fromEmail")) or
    empty(service("settings")->get("Email.fromName"))
): ?>
<div class="alert alert-warning d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
        <use xlink:href="#exclamation-triangle-fill" />
    </svg>
    <div>
        Es wurde kein Mail Absender definiert, dieser ist notwendig damit das versenden von Mails funktioniert. <br><a href="<?= base_url(
            route_to("admin.settings"),
        ) ?>" class="alert-link">Jetzt anpassen</a>
    </div>
</div>
<?php endif; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card card-lg">
                    <div class="card-body markdown">
                        <?=$changelog?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
</div>

<?= $this->endSection() ?>