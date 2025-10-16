<?php

return [
    'default' => 'customer',

    'roles' => [
        'admin' => [
            'label' => 'Administrator',
            'description' => 'Full platform access including user and content management.',
        ],
        'agen' => [
            'label' => 'Property Agent',
            'description' => 'Manage listings, documents, and client schedules.',
        ],
        'customer' => [
            'label' => 'Customer',
            'description' => 'View personal dashboard content and browse public listings.',
        ],
    ],

    'permissions' => [
        'admin' => ['*'],
        'agen' => [
            'view-dashboard',
            'manage-properties',
            'manage-documents',
            'manage-schedule',
            'view-team-metrics',
            'access-shortcuts',
        ],
        'customer' => [
            'view-dashboard',
        ],
    ],

    'inherits' => [
        'admin' => ['agen'],
        'agen' => ['customer'],
    ],
];
