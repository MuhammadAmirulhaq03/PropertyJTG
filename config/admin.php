<?php

return [
    'rail' => [
        // Start the floating admin rail collapsed by default. Override via ENV.
        // Set ADMIN_RAIL_COLLAPSED_DEFAULT=false to expand by default.
        'collapsed_default' => env('ADMIN_RAIL_COLLAPSED_DEFAULT', true),
    ],
];

