<?php


return [
    'name' => env('CONVERSATION_NAME', 'Laravel Conversation'),


    'storage_disk_name' => env('CONVERSATION_STORAGE_DISK', 'public'),

    'routes' => [
        'prefix' => env('CONVERSATION_ROUTES_PREFIX', 'conversation'),
        'middleware' => env('CONVERSATION_ROUTES_MIDDLEWARE', ['web', 'auth']),
        'namespace' => env('CONVERSATION_ROUTES_NAMESPACE', 'NahidFerdous\Conversation\Http\Controllers'),
    ],
    'api_routes' => [
        'prefix' => env('CONVERSATION_API_ROUTES_PREFIX', 'conversation/api'),
        'middleware' => env('CONVERSATION_API_ROUTES_MIDDLEWARE', ['api']),
        'namespace' => env('CONVERSATION_API_ROUTES_NAMESPACE', 'NahidFerdous\Conversation\Http\Controllers\Api'),
    ],


    'pusher' => [
        'debug' => env('APP_DEBUG', false),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
            'host' => env('PUSHER_HOST') ?: 'api-' . env('PUSHER_APP_CLUSTER', 'mt1') . '.pusher.com',
            'port' => env('PUSHER_PORT', 443),
            'scheme' => env('PUSHER_SCHEME', 'https'),
            'encrypted' => true,
            'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
        ],
    ],


    'user_avatar' => [
        'folder' => 'users-avatar',
        'default' => 'avatar.png',
    ],


    'gravatar' => [
        'enabled' => true,
        'image_size' => 200,
        'imageset' => 'identicon'
    ],


    'attachments' => [
        'folder' => 'attachments',
        'download_route_name' => 'attachments.download',
        'allowed_images' => (array)['png', 'jpg', 'jpeg', 'gif'],
        'allowed_files' => (array)['zip', 'rar', 'txt'],
        'max_upload_size' => env('CONVERSATION_MAX_FILE_SIZE', 150), // MB
    ],


    'colors' => (array)[
        '#2180f3',
        '#2196F3',
        '#00BCD4',
        '#3F51B5',
        '#673AB7',
        '#4CAF50',
        '#FFC107',
        '#FF9800',
        '#ff2522',
        '#9C27B0',
    ],

    'sounds' => [
        'enabled' => true,
        'public_path' => 'sounds/conversation',
        'new_message' => 'new-message-sound.mp3',
    ]
];
