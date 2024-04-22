<?php

use CodeIgniter\Router\RouteCollection;

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->addRedirect("/", "dashboard");

$routes->get("dashboard", "HomeController::index", [
    "as" => "home",
    "filter" => "permission:home.index",
]);

$routes->group("abacus", static function ($routes) {
    $routes->get("", "AbaAddressController::index", [
        "as" => "abacus.index",
        "filter" => "permission:abacus.index",
    ]);
    $routes->post("", "AbaAddressController::index", [
        "filter" => "permission:abacus.index",
    ]);
});


$routes->group("testimonial", static function ($routes) {
    $routes->get("", "TestimonialController::index", [
        "as" => "testimonial.index",
        "filter" => "permission:testimonial.index",
    ]);
    $routes->match(["get", "post"], "register", "TestimonialController::form", [
        "as" => "testimonial.register"
    ]);
    $routes->get("v/(:any)", "TestimonialController::view/$1", [
        "as" => "testimonial.view"
    ]);
    $routes->get("p/(:any)", "TestimonialController::preview/$1", [
        "as" => "testimonial.preview",
        "filter" => "permission:testimonial.preview",
    ]);
    $routes->match(["get", "post"], "edit/(:num)", "TestimonialController::edit/$1", [
        "as" => "testimonial.edit",
        "filter" => "permission:testimonial.edit"
    ]);
    
    $routes->get("form/", "TestimonialFormController::index", [
        "as" => "testimonialForm.index",
        "filter" => "permission:testimonial.forms",
    ]);
    $routes->match(["get", "post"], "form/add", "TestimonialFormController::add", [
        "as" => "testimonialForm.add",
        "filter" => "permission:testimonial.forms",
    ]);
    $routes->match(["get", "post"], "form/(:num)/edit", "TestimonialFormController::edit/$1", [
        "as" => "testimonialForm.edit",
        "filter" => "permission:testimonial.forms",
    ]);
});

$routes->get("changelog", "HomeController::changelog", [
    "as" => "changelog",
    "filter" => "permission:home.index",
]);

$routes->match(["get", "post"], "message", "MessageController::index", [
    "as" => "message.index",
    "filter" => "permission:message.index",
]);

$routes->post("dashboard/feedback", "HomeController::feedback", [
    "as" => "feedback",
    "filter" => "permission:home.index",
]);

$routes->group("mail", static function ($routes) {
    $routes->get("new", "MailController::index", [
        "as" => "mail.index",
        "filter" => "permission:mail.index",
    ]);
    $routes->post("new", "MailController::send", [
        "filter" => "permission:mail.index",
    ]);
    $routes->get("(:num)", 'MailController::index/$1', [
        "as" => "mail.load",
        "filter" => "permission:mail.index",
    ]);
    $routes->post("save", "MailController::save", [
        "as" => "mail.save",
        "filter" => "permission:mail.index",
    ]);
    $routes->post("edit/(:num)", 'MailController::save/$1', [
        "as" => "mail.edit",
        "filter" => "permission:mail.index",
    ]);
    $routes->get("sent", "MailController::sent", [
        "as" => "mail.sent",
        "filter" => "permission:mail.index",
    ]);
    $routes->get("sent/(:num)", 'MailController::detail/$1', [
        "as" => "mail.detail",
        "filter" => "permission:mail.index",
    ]);
});

$routes->group("profile", static function ($routes) {
    $routes->get("user", "ProfileController::index", [
        "as" => "profile.index",
        "filter" => "permission:profile.index",
    ]);
    $routes->post("user", "ProfileController::updateProfile", [
        "filter" => "permission:profile.index",
    ]);
    $routes->get("password", "ProfileController::password", [
        "as" => "profile.password",
        "filter" => "permission:profile.password",
    ]);
    $routes->post("password", "ProfileController::updatePassword", [
        "filter" => "permission:profile.password",
    ]);
});

$routes->group("crm", static function ($routes) {
    $routes->get("websites", "WebsitesController::index", [
        "as" => "website.index",
        "filter" => "permission:website.index",
    ]);
    $routes->match(["get", "post"], "websites/add", "WebsitesController::add", [
        "as" => "website.add",
        "filter" => "permission:website.add",
    ]);
    $routes->get("websites/(:num)", 'WebsitesController::show/$1', [
        "as" => "website.show",
        "filter" => "permission:website.show",
    ]);
    $routes->match(
        ["get", "post"],
        "websites/(:num)/edit",
        'WebsitesController::edit/$1',
        [
            "as" => "website.edit",
            "filter" => "permission:website.edit",
        ],
    );
    $routes->get("invoices", "InvoicesController::index", [
        "as" => "invoice.index",
        "filter" => "permission:invoice.index",
    ]);
    $routes->match(["get", "post"], "invoices/add", "InvoicesController::add", [
        "as" => "invoice.add",
        "filter" => "permission:invoice.add",
    ]);
    $routes->get("invoices/(:num)", 'InvoicesController::show/$1', [
        "as" => "invoice.show",
        "filter" => "permission:invoice.show",
    ]);
    $routes->get("invoices/(:num)/export", 'InvoicesController::export/$1', [
        "as" => "invoice.export",
        "filter" => "permission:invoice.export",
    ]);
    $routes->match(
        ["get", "post"],
        "invoices/(:num)/edit",
        'InvoicesController::edit/$1',
        [
            "as" => "invoice.edit",
            "filter" => "permission:invoice.edit",
        ],
    );

    $routes->match(
        ["get", "post"],
        "invoices/(:num)/position/add",
        'InvoicesPositionController::add/$1',
        [
            "as" => "invoicepos.add",
            "filter" => "permission:invoice.edit",
        ],
    );
    $routes->match(
        ["get", "post"],
        "invoices/position/(:num)",
        'InvoicesPositionController::edit/$1',
        [
            "as" => "invoicepos.edit",
            "filter" => "permission:invoice.edit",
        ],
    );

    $routes->get("customers", "CustomersController::index", [
        "as" => "customer.index",
        "filter" => "permission:customer.index",
    ]);
    $routes->match(
        ["get", "post"],
        "customers/add",
        "CustomersController::add",
        [
            "as" => "customer.add",
            "filter" => "permission:customer.add",
        ],
    );
    $routes->get("customers/(:num)", 'CustomersController::show/$1', [
        "as" => "customer.show",
        "filter" => "permission:customer.show",
    ]);
    $routes->match(
        ["get", "post"],
        "customers/(:num)/edit",
        'CustomersController::edit/$1',
        [
            "as" => "customer.edit",
            "filter" => "permission:customer.edit",
        ],
    );

    $routes->match(
        ["get", "post"],
        "contacts/add",
        "CustomersContactController::add",
        [
            "as" => "contact.add",
            "filter" => "permission:customer.edit",
        ],
    );
    $routes->match(
        ["get", "post"],
        "contacts/edit/(:num)",
        'CustomersContactController::edit/$1',
        [
            "as" => "contact.edit",
            "filter" => "permission:customer.edit",
        ],
    );

    $routes->get("projects", "ProjectsController::index", [
        "as" => "project.index",
        "filter" => "permission:project.index",
    ]);
    $routes->match(["get", "post"], "projects/add", "ProjectsController::add", [
        "as" => "project.add",
        "filter" => "permission:project.add",
    ]);
    $routes->match(
        ["get", "post"],
        "projects/(:num)/edit",
        'ProjectsController::edit/$1',
        [
            "as" => "project.edit",
            "filter" => "permission:project.edit",
        ],
    );
    $routes->get("projects/(:num)", 'ProjectsController::show/$1', [
        "as" => "project.show",
        "filter" => "permission:project.show",
    ]);

    $routes->match(["get", "post"], "comments/add", "CommentsController::add", [
        "as" => "comment.add",
        "filter" => "permission:comment.add",
    ]);
    $routes->match(
        ["get", "post"],
        "comments/edit/(:num)",
        'CommentsController::edit/$1',
        [
            "as" => "comment.edit",
            "filter" => "permission:comment.edit",
        ],
    );
});

$routes->group("admin", static function ($routes) {
    $routes->match(
        ["get", "post"],
        "settings/general",
        "SettingsController::setting1",
        [
            "as" => "setting.1",
            "filter" => "permission:admin.settings",
        ],
    );
    $routes->match(
        ["get", "post"],
        "settings/company",
        "SettingsController::setting2",
        [
            "as" => "setting.2",
            "filter" => "permission:admin.settings",
        ],
    );
    $routes->match(
        ["get", "post"],
        "settings/mail",
        "SettingsController::setting3",
        [
            "as" => "setting.3",
            "filter" => "permission:admin.settings",
        ],
    );
    $routes->match(
        ["get", "post"],
        "settings/security",
        "SettingsController::setting4",
        [
            "as" => "setting.4",
            "filter" => "permission:admin.settings",
        ],
    );

    $routes->match(["get", "post"], "users", "UserController::index", [
        "as" => "user.index",
        "filter" => "permission:user.index",
    ]);
    $routes->match(["get", "post"], "users/add", "UserController::add", [
        "as" => "user.add",
        "filter" => "permission:user.add",
    ]);
    $routes->match(
        ["get", "post"],
        "users/(:num)/edit",
        'UserController::edit/$1',
        [
            "as" => "user.edit",
            "filter" => "permission:user.edit",
        ],
    );
    $routes->get("tags", "TagsController::index", [
        "as" => "tag.index",
        "filter" => "permission:admin.tags",
    ]);
    $routes->match(["get", "post"], "tags/add", "TagsController::add", [
        "as" => "tag.add",
        "filter" => "permission:admin.tags",
    ]);
    $routes->match(
        ["get", "post"],
        "tags/(:num)/edit",
        'TagsController::edit/$1',
        [
            "as" => "tag.edit",
            "filter" => "permission:admin.tags",
        ],
    );
});

$routes->group("tools", static function ($routes) {
    $routes->get("estos", "ToolsEstosController::index", [
        "as" => "estos.index",
        "filter" => "permission:tool.estos",
    ]);
    $routes->post("estos/abacus", "ToolsEstosController::importAbacus", [
        "as" => "estos.abacus",
        "filter" => "permission:tool.estos",
    ]);
    $routes->post("estos/kalahari", "ToolsEstosController::importKalahari", [
        "as" => "estos.kalahari",
        "filter" => "permission:tool.estos",
    ]);
    $routes->get("estos/export", "ToolsEstosController::export", [
        "as" => "estos.export",
        "filter" => "permission:tool.estos",
    ]);
});

$routes->cli("cron", "CronController::index");
$routes->get("cron", "CronController::index");

$routes->group("api/0", static function ($routes) {
    /*
     * Routes with NEW API
     */

     $routes->delete("testimonial/(:num)", 'apiTestimonialController::delete/$1', [
        "filter" => "permission:testimonial.delete",
    ]);

    $routes->delete("testimonial/form/(:num)", 'apiTestimonialFormController::delete/$1', [
        "filter" => "permission:testimonial.forms",
    ]);

    $routes->delete("website/(:num)", 'apiWebsitesController::delete/$1', [
        "filter" => "permission:website.delete",
    ]);

    $routes->get(
        "customer/(:num)/websites",
        'apiCustomerController::websites/$1',
        ["filter" => "permission:website.index"],
    );
    $routes->get(
        "customer/(:num)/projects",
        'apiCustomerController::projects/$1',
        ["filter" => "permission:project.index"],
    );
    $routes->delete("customer/(:num)", 'apiCustomerController::delete/$1', [
        "filter" => "permission:customer.delete",
    ]);

    $routes->delete("project/(:num)", 'apiProjectController::delete/$1', [
        "filter" => "permission:project.delete",
    ]);

    $routes->delete(
        "contact/(:num)",
        'apiCustomerContactController::delete/$1',
        ["filter" => "permission:customer.delete"],
    );

    $routes->delete("invoice/(:num)", 'apiInvoiceController::delete/$1', [
        "filter" => "permission:invoice.delete",
    ]);
    $routes->delete(
        "invoice/position/(:num)",
        'apiInvoicePosController::delete/$1',
        ["filter" => "permission:invoice.edit"],
    );
    $routes->post(
        "invoice/position/(:num)/copy",
        'apiInvoicePosController::saveAsTemplate/$1',
        ["filter" => "permission:invoice.add"],
    );
    $routes->patch(
        "invoice/position/(:num)/up",
        'apiInvoicePosController::moveUp/$1',
        ["filter" => "permission:invoice.edit"],
    );
    $routes->patch(
        "invoice/position/(:num)/down",
        'apiInvoicePosController::moveDown/$1',
        ["filter" => "permission:invoice.edit"],
    );
    $routes->post(
        "invoice/(:num)/title",
        'apiInvoicePosController::addTitle/$1',
        ["filter" => "permission:invoice.edit"],
    );

    $routes->delete("comment/(:num)", 'apiCommentController::delete/$1', [
        "filter" => "permission:comment.delete",
    ]);

    $routes->delete("user/(:num)/", 'apiUserController::delete/$1', [
        "filter" => "permission:user.delete",
    ]);
    $routes->patch(
        "user/(:num)/password",
        'apiUserController::resetPassword/$1',
        ["filter" => "permission:user.edit"],
    );

    $routes->delete("tag/(:num)", 'apiTagController::delete/$1', [
        "filter" => "permission:admin.tags",
    ]);

    $routes->post("message", "apiMessageController::create", [
        "filter" => "permission:message.add",
    ]);
    $routes->delete("chat/(:num)", 'apiMessageController::deleteChat/$1', [
        "filter" => "permission:message.delete",
    ]);

    $routes->delete("mail/(:num)", 'apiMailController::delete/$1', [
        "filter" => "permission:mail.index",
    ]);
    $routes->patch("mail/(:num)/reset", 'apiMailController::resetError/$1', [
        "filter" => "permission:mail.index",
    ]);
    

    /*
     * OLD Routes
     */
    $routes->delete(
        "website/delete/(:num)",
        'WebsitesController::apiDelete/$1',
    );
    $routes->get("websites", "apiWebsitesController::getWebsites");

    $routes->get("projects", "apiProjectsController::getProjects");

    $routes->delete(
        "invoice/position/(:num)/delete",
        'InvoicesPositionController::apiDelete/$1',
    );

    $routes->delete("tag/delete/(:num)", 'TagsController::apiDelete/$1');
});

$routes->group("api/v1", static function ($routes) {
    $routes->get("website", "apiWebsitesController::index");
    $routes->post("website", "apiWebsitesController::create");
    $routes->get("website/(:num)", 'apiWebsitesController::show/$1');
    $routes->delete("website/(:num)", 'apiWebsitesController::delete/$1');
    $routes->patch("website/(:num)", 'apiWebsitesController::update/$1');

    $routes->get("customer", "apiCustomerController::index");
    $routes->post("customer", "apiCustomerController::create");
    $routes->delete("customer/(:num)", 'apiCustomerController::delete/$1');
    $routes->get("customer/(:num)", 'apiCustomerController::show/$1');
    $routes->get(
        "customer/(:num)/projects",
        'apiCustomerController::projects/$1',
    );
    $routes->get(
        "customer/(:num)/websites",
        'apiCustomerController::websites/$1',
    );

    $routes->delete("project/(:num)", 'apiProjectController::delete/$1');

    $routes->delete(
        "contact/(:num)",
        'apiCustomerContactController::delete/$1',
    );

    $routes->delete("invoice/(:num)", 'apiInvoiceController::delete/$1');
    $routes->get("invoice/(:num)", 'apiInvoiceController::show/$1');


    $routes->delete("invoice/position/(:num)",'apiInvoicePosController::delete/$1');
    $routes->post(
        "invoice/position/(:num)/copy",
        'apiInvoicePosController::saveAsTemplate/$1'
    );
    $routes->patch(
        "invoice/position/(:num)/up",
        'apiInvoicePosController::moveUp/$1'
    );
    $routes->patch(
        "invoice/position/(:num)/down",
        'apiInvoicePosController::moveDown/$1'
    );

    $routes->delete("comment/(:num)", 'apiCommentController::delete/$1');

    $routes->delete("user/(:num)", 'apiUserController::delete/$1');
    $routes->patch(
        "user/(:num)/password",
        'apiUserController::resetPassword/$1',
    );

    $routes->post("message", "apiMessageController::create");
    $routes->get("message/receivers", "apiMessageController::getReceivers");
    $routes->delete("chat/(:num)", 'apiMessageController::deleteChat/$1');

    $routes->delete("mail/(:num)", 'apiMailController::delete/$1');
    $routes->patch("mail/(:num)/reset", 'apiMailController::resetError/$1');
});

service("auth")->routes($routes);