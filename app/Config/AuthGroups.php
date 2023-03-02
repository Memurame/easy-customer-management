<?php

declare(strict_types=1);

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
     * The available authentication systems, listed
     * with alias and class name. These can be referenced
     * by alias in the auth helper:
     *      auth('api')->attempt($credentials);
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'user' => [
            'title'       => 'User',
            'description' => 'General users of the site. Often customers.',
        ]
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system. Each system is defined
     * where the key is the
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.access'        => 'Can access the sites admin area',
        'admin.settings'      => 'Can access the main site settings',
        'user.manage-admins' => 'Can manage other admins',
        'user.create'        => 'Can create new non-admin users',
        'user.edit'          => 'Can edit existing non-admin users',
        'user.delete'        => 'Can delete existing non-admin users',
        'user.show'        => 'Can show existing non-admin users',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'user.*'
        ],
        'admin' => [
            'admin.settings',
            'user.create',
            'user.edit',
            'user.delete',
            'user.show'
        ],
        'user' => []
    ];
}