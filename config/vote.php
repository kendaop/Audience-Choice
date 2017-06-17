<?php

return [

    'app' => [
        /**
         * The number of failed login attempts before a user is locked out.
         */
        'maxLoginAttempts'  => env('MAX_LOGIN_ATTEMPTS', 10),

        /**
         * The number of seconds since the previous failed login attempt before the user is reset.
         */
        'loginAttemptStorageLength' => env('LOGIN_ATTEMPT_STORAGE_LENGTH', 120),

        /**
         * The number of seconds a user is locked out before they're allowed to try to login again.
         */
        'lockoutLength' => env('LOCKOUT_LENGTH', 120)
    ],

    'categories' => [

        /**
         * If set to 'true', categories will be used for visual display only.
         * Voting will be treated as if all categories were combined into one.
         */
        'squash'    => env('SQUASH_CATEGORIES', false),
    ],

    'messages' => [
        'welcome'           => env('WELCOME_MESSAGE', 'Welcome!'),
        'invalidSession'    => env('SOMETHING_WENT_WRONG_MESSAGE', 'Something went wrong. Please try again.'),
        'invalidAccessCode' => env('INVALID_CODE_MESSAGE', 'Invalid Access Code'),
        'rateLimited'       => env('MAX_LOGIN_ATTEMPTS_MESSAGE', 'Max login attempts reached. Please wait a while before attempting again.')
    ],

    'branding' => [
        'logo' => env('MAIN_LOGO')
    ],

    'test' => [
        'default' => [
            'accessCodeId'  => env('DEFAULT_ACCESS_CODE_ID', 1),
            'categoryId'    => env('DEFAULT_CATEGORY_ID', 1),
            'filmId'        => env('DEFAULT_FILM_ID', 1)
        ],
        'allCategory' => [
            'accessCodeId'  => env('ALL_CATEGORY_ACCESS_CODE_ID', 1)
        ]
    ]
];