<?php

$isProduction = env('APP_ENV') === 'production';

return [
    'folders' => [
        'event' => [
            'db_path' => '/storage/event',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/event'
                : 'storage/event',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/event'
                : storage_path('app/public/event'),
        ],
        'sponsor' => [
            'db_path' => '/storage/sponsor',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/sponsor'
                : 'storage/sponsor',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/sponsor'
                : storage_path('app/public/sponsor'),
        ],
        // Tambahkan lainnya sesuai kebutuhan
    ]
];
