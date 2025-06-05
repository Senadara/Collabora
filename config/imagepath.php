<?php

$baseUrlPath = 'storage';
$baseLocalPath = storage_path('app/public');
$baseProductionPath = '/home/senadara/public_html/collabora.senadara.my.id/storage';

$isProduction = env('APP_ENV') === 'production';

return [
    'folders' => [
        'event' => [
            'url_path' => 'storage/event',
            'storage_path' => env('APP_ENV') === 'production'
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/event'
                : storage_path('app/public/event'),
        ],
        'sponsor' => [
            'url_path' => 'storage/sponsor',
            'storage_path' => env('APP_ENV') === 'production'
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/sponsor'
                : storage_path('app/public/sponsor'),
        ],
        // Tambahkan lainnya sesuai kebutuhan
    ]
];
