<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        "home.index" => "Home",
        "admin.access" => "Can access the sites admin area",
        "admin.settings" => "Can access the site settings",
        "admin.tags" => "Add, edit and delete tags",
        "user.manage-admins" => "Can manage other admins",
        "user.add" => "Can create new non-admin users",
        "user.edit" => "Can edit existing non-admin users",
        "user.delete" => "Can delete existing non-admin users",
        "user.index" => "Can show existing non-admin users",
        "customer.index" => "List customers",
        "customer.edit" => "Edit customers",
        "customer.show" => "Show customers",
        "customer.add" => "Add customers",
        "customer.delete" => "Delete customers",
        "comment.add" => "View, add, edit and delete comments",
        "comment.edit" => "Edit comments",
        "comment.delete" => "Kommentare löschen",
        "project.index" => "List projects",
        "project.show" => "Show projects",
        "project.edit" => "Edit projects",
        "project.add" => "Add projects",
        "project.delete" => "Delete projects",
        "website.index" => "List websites",
        "website.show" => "Show websites",
        "website.edit" => "Edit websites",
        "website.add" => "Add websites",
        "website.delete" => "Delete websites",
        "invoice.index" => "List invoices",
        "invoice.show" => "Show invoices",
        "invoice.edit" => "Edit invoices",
        "invoice.add" => "Add invoices",
        "invoice.delete" => "Delete invoices",
        "invoice.export" => "Export invoice",
        "invoice.template" => "Rechnungsposition Vorlagen verwalten",
        "tool.menu" => "Zeigt das Tools Menu an",
        "tool.estos" => "Estos Telefonliste",
        "profile.index" => "Kann sein Profil bearbeiten",
        "profile.password" => "Kann sein Passswortändern",
        "message.index" => "Nachrichten Übersicht",
        "message.add" => "Nachrichten senden",
        "mail.index" => "Mails anzeigen",
        "testimonial.index" => "Testimonial anzeigen",
        "testimonial.edit" => "Testimonial bearbeiten",
        "testimonial.preview" => "Testimonial Vorschau",
        "testimonial.delete" => "Testimonial Löschen",
        "testimonial.forms" => "Testimonial Formulare verwalten",
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [];

    public function __construct()
    {
        $groups = model("GroupModel")->findAll();

        
        foreach ($groups as $group) {
            $arr = [];
            if($group->name == 'superadmin'){
                // The Superadmin group gets all existing permissions.
                foreach ($this->permissions as $permission => $permissionDesc) {
                    $explode = explode('.', $permission)[0];
                    if(!in_array($explode.'.*', $arr)){
                        $arr[] = $explode .'.*';
                    }
                    
                }
            } else {
                // The permissions of the group are read from the database and set accordingly.
                $groupPermissions = model("GroupPermissionModel")
                    ->where("group_id", $group->id)
                    ->findAll();
                foreach ($groupPermissions as $groupPermission) {
                    $arr[] = $groupPermission->permission;
                }
            }
            
            $this->matrix[$group->name] = $arr;

            $this->groups[$group->name] = [
                "title" => $group->title,
                "description" => $group->description,
                "isAdmin" => $group->is_admin,
            ];
        }
    }
}
