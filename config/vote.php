<?php

return [

    'categories' => [

        /**
         * If set to 'true', categories will be used for visual display only.
         * Voting will be treated as if all categories were combined into one.
         */
        'squash'   => true,
    ],

    'messages' => [
        'welcome'           => env('WELCOME_MESSAGE', ''),
        'invalidSession'    => env('INVALID_SESSION_MESSAGE', ''),
        'invalidAccessCode' => env('INVALID_CODE_MESSAGE', '')
    ],
];