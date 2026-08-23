<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Contact points
    |--------------------------------------------------------------------------
    |
    | The "Book a Call" buttons and the floating WhatsApp button read from
    | here, so the number changes in one place instead of ten. The WhatsApp
    | value is international format, digits only — no +, spaces, or dashes.
    | e.g. +1 (415) 555-0142 -> 14155550142
    |
    */

    'phone' => env('SITE_PHONE', '+8801779440297'),

    'whatsapp' => env('SITE_WHATSAPP', '15550000000'),

    /*
    |--------------------------------------------------------------------------
    | Primary navigation
    |--------------------------------------------------------------------------
    |
    | Route name => link label. Drives the desktop nav, the mobile drawer, and
    | the footer nav, so a new page is added in one place. Order is the order
    | it renders in.
    |
    */

    'nav' => [
        'home' => 'Home',
        'services' => 'Services',
        'case-studies' => 'Case Studies',
        'testimonials' => 'Testimonials',
        'contact' => 'Contact',
    ],

];
