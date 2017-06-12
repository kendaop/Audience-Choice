<?php

return [

    'categories' => [

        /**
         * If set to 'true', categories will be used for visual display only.
         * Voting will be treated as if all categories were combined into one.
         */
        'squash'   => env('SQUASH_CATEGORIES', false),
    ],

    'messages' => [
        'welcome'           => env('WELCOME_MESSAGE', 'Welcome!'),
        'invalidSession'    => env('INVALID_SESSION_MESSAGE', 'Something went wrong. Please try again.'),
        'invalidAccessCode' => env('INVALID_CODE_MESSAGE', 'Invalid Access Code')
    ],

    'branding' => [
        'logo' => env('MAIN_LOGO')
    ],

    'test' => [
        'default' => [
            'accessCodeId' => env('DEFAULT_ACCESS_CODE_ID', 1),
            'categoryId' => env('DEFAULT_CATEGORY_ID', 1),
            'filmId' => env('DEFAULT_FILM_ID', 1)
        ],
        'allCategory' => [
            'accessCodeId' => env('ALL_CATEGORY_ACCESS_CODE_ID', 1)
        ]
    ]
];